<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Service\GoogleBooksApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    private $googleBooksApiService;
    private $bookRepository;
    private $security;

    public function __construct(GoogleBooksApiService $googleBooksApiService, BookRepository $bookRepository, Security $security)
    {
        $this->googleBooksApiService = $googleBooksApiService;
        $this->bookRepository = $bookRepository;
        $this->security = $security;
    }

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {


        // Récupérer l'utilisateur connecté en utilisant Security
        $utilisateur = $this->security->getUser();

        // Recherche des livres en fonction de l'utilisateur connecté ou de tous les livres si personne n'est connecté
        $booksFromDB = $utilisateur ? $this->bookRepository->findBy(['utilisateur' => $utilisateur]) : $this->bookRepository->findAll();

        $books = [];
        foreach ($booksFromDB as $book) {
            // Récupération des détails de chaque livre via l'API Google Books
            $bookDetails = $this->googleBooksApiService->findBookByTitleAndAuthor($book->getTitle(), $book->getAuthor());
            if ($bookDetails) {
                $books[] = $bookDetails;
            }
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'books' => $books
        ]);
    }

    // #[Route('/add-book', name: 'add_book', methods: ['POST'])]
    // public function addBook(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $title = $request->request->get('title');
    //     $author = $request->request->get('author');
    //     $utilisateur = $this->security->getUser();

    //     $bookDetails = $this->googleBooksApiService->findBookByTitleAndAuthor($title, $author);

    //     if (!$bookDetails) {
    //         $this->addFlash('error', 'Aucun livre trouvé avec ce titre et auteur.');
    //         return $this->redirectToRoute('homepage');
    //     }

    //     foreach ($bookDetails as $bookData) {
    //         $book = new Book();
    //         $book->setTitle($bookData['title']);
    //         // Prend le premier auteur s'il existe, sinon attribue "Auteur inconnu"
    //         $book->setAuthor($bookData['authors'][0] ?? 'Auteur inconnu');
    //         $book->setUtilisateur($utilisateur);

    //         $entityManager->persist($book);
    //     }

    //     $entityManager->flush();

    //     $this->addFlash('success', 'Livres ajoutés avec succès.');
    //     return $this->redirectToRoute('homepage');
    // }
}
