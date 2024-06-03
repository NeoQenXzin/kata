<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class GoogleBooksApiService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, #[Autowire('%env(string:GOOGLE_BOOKS_API_KEY)%')]  string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function findBookByTitleAndAuthor($title, $author)
    {
        $response = $this->client->request(
            'GET',
            'https://www.googleapis.com/books/v1/volumes',
            [
                'query' => [
                    'q' => 'intitle:' . urlencode($title) . '+inauthor:' . urlencode($author),
                    // 'key' => $this->apiKey,
                    'maxResults' => 10, // Augmentez le nombre de résultats récupérés pour avoir plus de choix
                    'langRestrict' => 'fr'
                ]
            ]
        );

        $data = $response->toArray(); // Convert the response to an array

        // Check if 'items' key exists and filter books with image links
        if (array_key_exists('items', $data)) {
            $filteredBooks = array_filter($data['items'], function ($item) {
                return isset($item['volumeInfo']['imageLinks']['thumbnail']); // Assurez-vous que l'entrée dispose d'un lien vers une image
            });

            return array_slice($filteredBooks, 0, 1); // Retourne uniquement le premier résultat avec une image
        } else {
            // Handle the case where no items are found
            return [];
        }
    }
}
