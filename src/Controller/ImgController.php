<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Img;
use App\Entity\RelationAlbumAndImage;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\DateTimeImmutable;

class ImgController extends AbstractController
{
    #[Route('/img/upload', name: 'img.upload')]
    public function upload(Request $request, EntityManagerInterface $em): Response|FileException
    {
        /** @var UploadedFile|null $file */
        $file = $request->files->get('file');
        $config = $this->getParameter('imgConfig');
        $user = $this->getUser();


        if ($file instanceof UploadedFile) {


            $fileName = uniqid('img', true).'.'.$file->getClientOriginalExtension();

            try {
                $file->move($config['path'], $fileName);
            }catch (FileException $exception){
                return $exception;
            }

            $img = (new Img())
                ->setImageName($fileName)
                ->setDateCreate(new DateTimeImmutable(true))
                ->setUserCreate($user->getUserIdentifier());

            $em->persist($img);
            $em->flush();

            return $this->json(
                [
                    'success' => true,
                    'id' => $img->getId()
                ]
            );
        }
        return $this->json(
            [
                'success' => false
            ]
        );
    }


    #[Route('/img/load/{id<\d+>}', name: 'img.load', methods: ['GET'])]
    public function load(Img $img): Response
    {
        return $this->json([
            'success' => true,
            'data' => [
                'id' => $img->getId(),
                'path' => $img->getImageName()
            ]
        ]);
    }

    #[Route('/img/delete/{id<\d+>}', name: 'img.delete')]
    public function delete(RelationAlbumAndImage $img, EntityManagerInterface $em, Filesystem $filesystem): Response
    {
        $config = $this->getParameter('imgConfig');
        $path = $config['path'].'/'.$img->getIdImage()->getImageName();
        $em->remove($img);
        $filesystem->remove($path);
        $em->flush();

        return $this->redirectToRoute('update_album', ['id' => $img->getIdAlbum()->getId()]);
    }

    #[Route('/album/delete/{id<\d+>}', name: 'album.delete')]
    public function adelete(Album $album, EntityManagerInterface $em, Filesystem $filesystem): Response
    {
        $img = $album->getImages();
        $config = $this->getParameter('imgConfig');

        foreach ($img as $image)
        {
            $path = $config['path'].'/'.$image->getIdImage()->getImageName();
            $em->remove($image);
            $em->flush();
            $filesystem->remove($path);
        }

        $em->remove($album);
        $em->flush();

        return $this->redirectToRoute('admin_all_album');
    }

    #[Route('/img/delet/{id<\d+>}', name: 'img.delet')]
    public function delet(Img $img, EntityManagerInterface $em, Filesystem $filesystem){
        $path = $this->getParameter('imgConfig')['path'].'/'.$img->getImageName();
        $em->remove($img);
        $filesystem->remove($path);
        $em->flush();
    }
}