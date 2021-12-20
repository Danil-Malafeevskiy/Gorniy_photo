<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
;
class RegistrationController extends AbstractController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/registration', name: 'registration')]
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this -> createForm(RegistrationFormType::class, $user);

        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_ADMIN']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
