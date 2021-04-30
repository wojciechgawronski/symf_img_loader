<?php


namespace App\Controller;

use App\Entity\Photo;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    #[Route('/new-photos', name: '')]
    public function index()
    {

    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route('/set/photo/as/private/{id}', name: 'set_photo_as_private')]
    public function setMyPhotoAsPrivate(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $myPhoto = $entityManager->getRepository(Photo::class)->find($id);

        // compare logged user to author ohoto
        if ($this->getUser() == $myPhoto->getUser()){
            try {
                $myPhoto->setIsPublic(0);
                $entityManager->persist($myPhoto);
                $entityManager->flush();
                $this->addFlash('succes', 'Ustawiono jako prywatne');
            } catch ( \Exception $e) {
                $this->addFlash('error', 'Coś poszło nie tak..');
            }
        }
        return $this->redirectToRoute('new_photos');
    }
}