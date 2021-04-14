<?php

namespace App\Controller;

use App\Entity\Photo;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LatestPhotoController extends AbstractController
{
    #[Route('/latest', name: 'latest_photos')]
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $latestPhotoPublic = $entityManager->getRepository(Photo::class)->findBy(['is_public' => true]);

        return $this->render('', [
            'latestPhotoPublic' => $latestPhotoPublic
        ]);
    }
}