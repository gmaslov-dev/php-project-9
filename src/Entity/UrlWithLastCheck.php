<?php

namespace Hexlet\Code\Entity;

class UrlWithLastCheck
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $lastCheckDate,
        public ?int $lastCheckStatus
    ) {
    }
}
