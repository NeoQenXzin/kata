<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{

    public function __construct()
    {
    }

    #[Route('/log', name: 'logine')]
    public function index()
    {

        return $this->render('security/login.html.twig');
    }
}
