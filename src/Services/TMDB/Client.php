<?php

namespace App\Services\TMDB;

use App\DTO\MovieDTO;
use Symfony\Contracts\Cache\ItemInterface;
use  \Symfony\Contracts\HttpClient\HttpClientInterface;
use  \Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Client
{

    private FilesystemAdapter $cache;

    public function __construct(private readonly HttpClientInterface $tmdbClient)
    {
        $this->cache = new FilesystemAdapter();
    }

    /**
     * @return MovieDTO[]
     */
    public function popular(): array
    {
        return $this->cache->get("popular", function (ItemInterface $item) {
            $item->expiresAfter(3600);
            $response = $this->tmdbClient->request('GET', '/3/movie/popular', [
                'query' => [
                    'language' => 'fr-FR',
                ]
            ]);

            $data = $response->toArray();


            return array_map(fn(array $movie) => new MovieDTO($movie['overview'], $movie["poster_path"], $movie['title']), $data['results']);

        });


    }

    public function upcoming(): array
    {
        return $this->cache->get("upcoming", function (ItemInterface $item) {
            $item->expiresAfter(3600);
            $response = $this->tmdbClient->request('GET', '/3/movie/upcoming', [
                'query' => [
                    'language' => 'fr-FR',
                ]
            ]);

            $data = $response->toArray();


            return array_map(fn(array $movie) => new MovieDTO($movie['overview'], $movie["poster_path"], $movie['title']), $data['results']);

        });


    }


    /**
     * @return MovieDTO[]
     */
    public function query(string $query): array
    {

        $response = $this->tmdbClient->request('GET', '/3/search/movie', [
            'query' => [
                'query' => $query,
                'language' => 'fr-FR',
            ]
        ]);

        $data = $response->toArray();


        return array_map(fn(array $movie) => new MovieDTO($movie['overview'], $movie["poster_path"], $movie['title']), $data['results']);

    }


}
