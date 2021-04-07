<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\UploadPhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(UploadPhotoType::class);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()) {

            if($this->getUser()){ // czy zalogowany ?

                /*
                 * Zapis zdjęcia do pliku
                 */
                $pictureFileName = $form->get('filename')->getData();
                if($pictureFileName){
                    /** @var UploadedFile $pictureFileName */
                    $orginalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $orginalFileName);
                    $safeFileName = $safeFileName . "_" . uniqid() . '.' . $pictureFileName->guessClientExtension();
                    $pictureFileName->move('images/hosting', $safeFileName);

                    /*
                     * Zapis pliku do bazy danych
                     */
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityPhoto = new Photo();
                    $entityPhoto->setFilename($safeFileName);
                    $entityPhoto->setIsPublic($form->get('is_public')->getData());
                    $entityPhoto->setUploadedAt(new \DateTime());
                    $entityPhoto->setUser($this->getUser());

                    $entityManager->persist($entityPhoto);
                    $entityManager->flush();
                }

            }
        }

        return $this->render('index/index.html.twig', [
            'uploadForm' => $form->createView()
        ]);
    }
}
