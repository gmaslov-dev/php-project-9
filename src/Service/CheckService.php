<?php

namespace Hexlet\Code\Service;

use Hexlet\Code\Repository\CheckRepository;

class CheckService
{
    private CheckRepository $checkRepository;

    public function __construct(CheckRepository $checkRepository)
    {
        $this->checkRepository = $checkRepository;
    }

    public function getChecksForUrl(int $urlId): array
    {
        return $this->checkRepository->findByUrlId($urlId);
    }
}
