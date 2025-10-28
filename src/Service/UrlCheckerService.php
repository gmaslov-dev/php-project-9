<?php

namespace Hexlet\Code\Service;

use DiDom\Document;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Hexlet\Code\Entity\Check;
use Hexlet\Code\Repository\UrlRepository;

readonly class UrlCheckerService
{
    public function __construct(
        private Client $httpClient,
        private UrlRepository $urlRepository,
    ) {
    }

    public function checkUrlById(int $urlId): ?Check
    {
        $url = $this->urlRepository->findById($urlId);
        if (!$url) {
            return null;
        }

        $name = $url->getName();

        try {
            $res = $this->httpClient->request('GET', $name);
            $statusCode = $res->getStatusCode();
            $doc = new Document($name, true);
            $h1 = optional($doc->first('h1'))->text();
            $title = optional($doc->first('title'))->text();
            $metaDescription = optional($doc->first('meta[name="description"]'))->attr('content');
        } catch (RequestException | GuzzleException) {
            return null;
        }

        return Check::fromArray([
            'url_id' => $urlId,
            'status_code' => $statusCode,
            'h1' => $h1,
            'title' => $title,
            'description' => $metaDescription
        ]);
    }
}
