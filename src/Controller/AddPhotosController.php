<?php

namespace App\Controller;

use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AddImgFormType;
use App\Entity\Img;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class AddPhotosController extends AbstractController
{
    #[Route('/add/photo', name: 'add_photos')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(AddImgFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('add_photos');
        }
        return $this->render('add_photo/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
