<?php

namespace Hexlet\Code\Entity;

class Check
{
    public function __construct(
        private readonly int $urlId,
        private readonly string $createdAt,
        private ?int $id = null,
        private ?int $statusCode = null,
        private ?string $h1 = null,
        private ?string $title = null,
        private ?string $description = null,
    ) {}

    public function getUrlId(): int
    {
        return $this->urlId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }


}