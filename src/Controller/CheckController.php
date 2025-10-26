<?php

namespace Hexlet\Code\Controller;

use Hexlet\Code\Repository\UrlRepository;
use Hexlet\Code\Validator\UrlValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Hexlet\Code\Entity\Url;
use Slim\Flash\Messages;

class CheckController
{
    public function __construct(
        protected Twig $view,
        protected UrlRepository $urlRepository,
        protected Messages $flash
    ) {
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $urlId = (int) $args['url_id'];

        dd($urlId);

        if (!$urlId) {
            return $response->withStatus(404);
        }

        // $checkUrl;

        $check = Check::fromArray($args);
        $this->urlRepository->save($check);

        return $response->withRedirect(urlFor('url.show', ['id' => $urlId]))->withStatus(302);
    }
}