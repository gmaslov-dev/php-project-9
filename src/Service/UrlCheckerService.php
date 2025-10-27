<?php

namespace Hexlet\Code\Service;

use DOMDocument;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Hexlet\Code\Entity\Check;
use Hexlet\Code\Repository\CheckRepository;
use Hexlet\Code\Repository\UrlRepository;

readonly class UrlCheckerService
{
    // Логика HTTP-запроса, извлечение данных, обработка ошибок
    public function __construct(
        private Client $httpClient,
        private UrlRepository $urlRepository,
        private CheckRepository $checkRepository
    ) {
    }

    public function checkUrlById(int $urlId): ?Check
    {
        $url = $this->urlRepository->findById($urlId);
        if (!$url) {
            return null;
        }

        $statusCode = null;
        $h1 = null;
        $title = null;
        $description = null;

        try {
            $res = $this->httpClient->request('GET', $url->getName());
            $statusCode = $res->getStatusCode();
            $html = (string) $res->getBody();

            $dom = new DOMDocument();
            @$dom->loadHTML($html);

            $h1Node = $dom->getElementsByTagName('h1')->item(0);
            $h1 = $h1Node?->textContent;

            $titleNode = $dom->getElementsByTagName('title')->item(0);
            $title = $titleNode?->textContent;

            $metas = $dom->getElementsByTagName('meta');
            foreach ($metas as $meta) {
                if (strtolower($meta->getAttribute('name')) === 'description') {
                    $description = $meta->getAttribute('content');
                    break;
                }
            }
        } catch (RequestException | GuzzleException) {
            return null;
        }

        $check = Check::fromArray([
            'url_id' => $urlId,
            'status_code' => $statusCode,
            'h1' => $h1,
            'title' => $title,
            'description' => $description
        ]);

        $this->checkRepository->save($check);

        return $check;
    }
}
