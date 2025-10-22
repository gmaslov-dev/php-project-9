<?php

namespace Hexlet\Code\Entity;

class Url
{
    public function __construct(
        private ?int            $id = null,
        private readonly string $name,
        private readonly string $createdAt
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['name'],
            $data['created_at']
        );
    }

    public function exists(): bool
    {
        return $this->id !== null;
    }
}
