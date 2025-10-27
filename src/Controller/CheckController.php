<?php

namespace Hexlet\Code\Controller;

use Hexlet\Code\Repository\CheckRepository;
use Hexlet\Code\Service\UrlCheckerService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Slim\Flash\Messages;

class CheckController
{
    public function __construct(
        protected Twig $view,
        protected CheckRepository $checkRepository,
        protected Messages $flash,
        protected UrlCheckerService $urlCheckerService,
    ) {
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $urlId = (int) $args['url_id'];

        if (!$urlId) {
            return $response->withStatus(404);
        }


        $check = $this->urlCheckerService->checkUrlById($urlId);
        //$this->checkRepository->save($check);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('urls.show', ['id' => $urlId]);

        $this->flash->addMessage('success', 'Страница успешно проверена');

        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }
}
