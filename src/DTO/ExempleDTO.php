<?php

namespace App\DTO;

readonly class ExempleDTO{
    public function __construct(
        public string $nom, 
        public string $prenom,
        public int $nbr
    ){}
}