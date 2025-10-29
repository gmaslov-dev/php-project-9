<?php

namespace Hexlet\Code\Entity;

use Carbon\Carbon;

class Url
{
    public function __construct(
        private readonly string $name,
        private readonly string $createdAt,
        private ?int $id = null,
    ) {
    }

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
        if (!isset($data['created_at'])) {
            $data['created_at'] = Carbon::now()->toDateTimeString();
        }

        return new self(
            $data['name'],
            $data['created_at'],
            $data['id'] ?? null
        );
    }

    public function exists(): bool
    {
        return $this->id !== null;
    }
}
