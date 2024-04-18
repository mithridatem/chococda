<?php

namespace App\DTO;

readonly class TopChocoblastTargetDTO
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly int $count
    ) {
    }
}
