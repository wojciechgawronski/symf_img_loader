<?php

namespace App\Controller;

use App\Form\UploadPhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $form = $this->createForm(UploadPhotoType::class);
        return $this->render('index/index.html.twig', [
            'uploadForm' => $form->createView()
        ]);
    }
}
