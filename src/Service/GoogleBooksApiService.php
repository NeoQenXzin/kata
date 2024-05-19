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
                    'key' => $this->apiKey
                ]
            ]
        );

        $data = $response->toArray(); // Convert the response to an array

        // Check if 'items' key exists
        if (array_key_exists('items', $data)) {
            return $data['items'];
        } else {
            // Handle the case where no items are found
            return [];
        }
    }
}
