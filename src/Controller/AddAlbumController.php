<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Img;
use App\Form\AddAlbumFormType;
use App\Form\AddImgFormType;
use App\Photos\FileManageInterfacePhotos;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddAlbumController extends AbstractController
{
    #[Route('/add/album', name: 'add_album')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $album = new Album();
        $form = $this->createForm(AddAlbumFormType::class, $album);
        $form->handleRequest($request);
        $user = $this->getUser();


        if($form->isSubmitted() && $form->isValid())
        {

            $em->persist($album);
            $album->setDateUpdate(new DateTimeImmutable(true));
            $album->setDatePublication(new DateTimeImmutable(true));
            $album->setDateCreate(new DateTimeImmutable(true));

            $album->setUserCreate($album->getUserCreate());
            $album->setUserUpdate($user->getUserIdentifier());


            $em->flush();

            return $this->redirectToRoute('add_album');
        }

        return $this->render('add_album/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
