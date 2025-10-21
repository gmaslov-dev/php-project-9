<?php

namespace Hexlet\Code\Entity;

class Url
{
    public function __construct(
        private ?int $id = null,
        private string $name,
        private string $createdAt
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}