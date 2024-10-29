<?php

namespace App\DTO;

final readonly class MovieDTO
{
    public function __construct
    (
        public string $poster_path,
        public ?string $overview,
        public string $title
    )
    {
    }
}
