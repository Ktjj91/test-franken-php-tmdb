<?php

namespace App\Twig;

use App\DTO\MovieDTO;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{

    public function getFilters(){
        return [
            new TwigFilter('movie_posters', [$this, 'movie_posters']),
        ];
    }

    public function movie_posters(MovieDTO $movieDTO) :string
    {

        return "https://image.tmdb.org/t/p/w300/$movieDTO->overview";

    }
}
