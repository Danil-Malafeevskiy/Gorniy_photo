<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('/base', name: 'base')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('base/index.html.twig', [
            'email' => $user->getUserIdentifier(),
        ]);
    }
}
