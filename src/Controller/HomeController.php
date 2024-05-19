<?php

namespace App\Controller;

use App\Service\GoogleBooksApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $googleBooksApiService;

    public function __construct(GoogleBooksApiService $googleBooksApiService)
    {
        $this->googleBooksApiService = $googleBooksApiService;
    }

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $books = $this->googleBooksApiService->findBookByTitleAndAuthor('Le Titre du Livre', 'Nom de l\'Auteur');
        // $books = $this->googleBooksApiService->findBookByTitleAndAuthor('Harry Potter', 'J.K. Rowling');
        // Assume you fetch user specific books and details in a real scenario
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'books' => $books
        ]);
    }
}
