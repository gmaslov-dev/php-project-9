<?php

namespace Hexlet\Code\Service;

use Hexlet\Code\Entity\UrlWithLastCheck;
use Hexlet\Code\Repository\CheckRepository;
use Hexlet\Code\Repository\UrlRepository;

readonly class UrlCheckService
{
    public function __construct(
        private UrlRepository $urlRepository,
        private CheckRepository $checkRepository
    ) {
    }

    public function getUrlsWithLastCheck(): array
    {
        $urls = $this->urlRepository->getAll();
        $result = [];

        foreach ($urls as $url) {
            $lastCheck = $this->checkRepository->findLastByUrlId($url->getId());

            $result[] = new UrlWithLastCheck(
                $url->getId(),
                $url->getName(),
                $lastCheck?->getCreatedAt(),
                $lastCheck?->getStatusCode()
            );
        }
        return $result;
    }
}
