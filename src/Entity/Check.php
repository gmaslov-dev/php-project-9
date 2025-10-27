<?php

namespace Hexlet\Code\Entity;

use Carbon\Carbon;

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
    ) {
    }

    public function getUrlId(): int
    {
        return $this->urlId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getH1(): ?string
    {
        return $this->h1;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }


    public static function fromArray(array $data): self
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = Carbon::now()->toDateTimeString();
        }

        return new self(
            $data['url_id'],
            $data['created_at'],
            $data['id'] ?? null,
            $data['status_code'] ?? null,
            $data['h1'] ?? null,
            $data['title'] ?? null,
            $data['description'] ?? null,
        );
    }


}