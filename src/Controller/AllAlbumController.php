<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\RelationAlbumAndImage;
use App\Form\AddAlbumFormType;
use App\Form\AddImgFormType;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class AllAlbumController extends AbstractController
{
    #[Route('/all/album', name: 'all_album')]
    public function allAlbum(): Response
    {
        $albums = $this->getDoctrine()->getRepository(Album::class);

        return $this->render('all_album/index.html.twig', [
            'albums' => $albums->findAll(),
        ]);
    }


    #[Route('/album/{id<\d+>}', name: '_album')]
    public function albumLoad(Album $album) : Response
    {
        return $this->render('all_album/album.html.twig', [
            'album' => $album
    ]);
    }

    #[Route('/admin/all/album', name: 'admin_all_album')]
    public function adminAllAlbum(): Response
    {
        $albums = $this->getDoctrine()->getRepository(Album::class);

        return $this->render('admin_all_album/index.html.twig', [
            'albums' => $albums->findAll(),
        ]);
    }

    #[Route ('admin/album/{id<\d+>}', name: 'admin_album')]
    public function adminAlbumLoad(Album $album) : Response
    {
        return $this->render('admin_all_album/admin_album.html.twig', [
            'album' => $album
        ]);
    }


    public function changeAlbum(Request $request, Album $album, EntityManagerInterface $em, bool $update)
    {
        $form = $this->createForm(AddAlbumFormType::class, $album);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($form->isSubmitted() && $form->isValid())
        {
            foreach ($form['images']->getData() as $img)
            {
                $Relation = (new RelationAlbumAndImage())
                    ->setIdAlbum($album)
                    ->setIdImage($img);

                $em->persist($Relation);
                $album->addImage($Relation);
            }

            if($update) {
                $em->persist($album);
                $album->setDateUpdate(new DateTimeImmutable(true));
                $album->setDateCreate($album->getDateCreate());
                $album->setUserUpdate($user->getUserIdentifier());
                $album->setUserCreate($album->getUserCreate());

                $em->flush();
                return $this->redirectToRoute('admin_all_album');
            }
            else{
                $em->persist($album);
                $album->setDateUpdate(new DateTimeImmutable(true));
                $album->setDateCreate(new DateTimeImmutable(true));
                $album->setUserUpdate($user->getUserIdentifier());
                $album->setUserCreate($user->getUserIdentifier());

                $em->flush();
                return $this->redirectToRoute('admin_all_album');
            }
        }

        if($update) {
            return $this->render('admin_all_album/update.html.twig', [
                'form' => $form->createView(),
                'album' => $album,
                ]);
        }
        else{
            return $this->render('add_album/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/add/album', name: 'add_album')]
    public function addAlbum(Request $request, EntityManagerInterface $em): Response
    {
        $album = new Album();

        return $this->changeAlbum($request, $album, $em, false);
    }

    #[Route('/update/album/{id<\d+>}', name: 'update_album')]
    public function updateAlbum(Request $request, Album $album, EntityManagerInterface $em): Response
    {
        return $this->changeAlbum($request, $album, $em, true);
    }
}
