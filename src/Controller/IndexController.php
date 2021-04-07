<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\UploadPhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
                 * Zapis pliku do bazy danych
                 */
                $entityManager = $this->getDoctrine()->getManager();
                $entityPhoto = new Photo();
                $entityPhoto->setFilename($form->get('filename')->getData());
                $entityPhoto->setIsPublic($form->get('is_public')->getData());
                $entityPhoto->setUploadedAt(new \DateTime());
                $entityPhoto->setUser($this->getUser());

                $entityManager->persist($entityPhoto);
                $entityManager->flush();

            }
        }

        return $this->render('index/index.html.twig', [
            'uploadForm' => $form->createView()
        ]);
    }
}
