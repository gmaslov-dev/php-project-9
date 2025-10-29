<?php

namespace Hexlet\Code\Service;

use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;
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

    /**
     * @throws InvalidSelectorException
     */
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
            /** @phpstan-ignore-next-line */
            $h1 = optional($doc->first('h1'))->text();
            /** @phpstan-ignore-next-line */
            $title = optional($doc->first('title'))->text();
            /** @phpstan-ignore-next-line */
            $metaDescription = optional($doc->first('meta[name="description"]'))->attr('content');

            return Check::fromArray([
                'url_id' => $urlId,
                'status_code' => $statusCode,
                'h1' => $h1,
                'title' => $title,
                'description' => $metaDescription
            ]);
        } catch (RequestException | GuzzleException) {
            return null;
        }
    }
}
