<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlavController extends AbstractController
{
    #[Route('/glav', name: 'glav')]
    public function index(): Response
    {
        $fm = "";
        $kk = "";

        $path = $this->getParameter('image_post_directory');
        $images = scandir($path);
        if ($images !== false) {

        }
        else {
            echo "<div style='text-align:center'>Директория пуста или произошла ошибка при сканировании.</div>";
        }

        return $this->render('glav/index.html.twig', [
            'images' => $images,
            'controller_name' => 'GlavController',
        ]);
    }
}
