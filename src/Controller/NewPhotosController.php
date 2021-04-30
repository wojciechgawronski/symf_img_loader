<?php

namespace App\Controller;

use App\Entity\Photo;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewPhotosController extends AbstractController
{
    #[Route('/new-photos', name: 'new_photos')]
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $latestPhotoPublic = $entityManager->getRepository(Photo::class)->findBy(['is_public' => true]);

//        dd($latestPhotoPublic);
        return $this->render('new_photos/index.html.twig', [
            'latestPhotoPublic' => $latestPhotoPublic
        ]);
    }
}