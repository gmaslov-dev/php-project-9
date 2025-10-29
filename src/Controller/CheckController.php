<?php

namespace Hexlet\Code\Controller;

use Hexlet\Code\Repository\CheckRepository;
use Hexlet\Code\Service\UrlCheckerService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Slim\Flash\Messages;

readonly class CheckController
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
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $redirectUrl = $routeParser->urlFor('urls.show', ['id' => (string) $urlId]);

        if (!$urlId) {
            $this->flash->addMessage('danger', 'Некорректный ID URL');
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $check = $this->urlCheckerService->checkUrlById($urlId);

        if (!$check) {
            $this->flash->addMessage('danger', 'Произошла ошибка при проверке, не удалось подключиться');
            return $response
                ->withHeader('Location', $redirectUrl)
                ->withStatus(302);
        }

        $this->checkRepository->save($check);
        $this->flash->addMessage('success', 'Страница успешно проверена');

        return $response
            ->withHeader('Location', $redirectUrl)
            ->withStatus(302);
    }
}
