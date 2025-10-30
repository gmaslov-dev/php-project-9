<?php

namespace Hexlet\Code\Controller;

use DiDom\Exceptions\InvalidSelectorException;
use Hexlet\Code\Repository\CheckRepository;
use Hexlet\Code\Service\UrlCheckerService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Flash\Messages;

class CheckController extends BaseController
{
    public function __construct(
        protected Twig $view,
        protected CheckRepository $checkRepository,
        protected Messages $flash,
        protected UrlCheckerService $urlCheckerService,
    ) {
        parent::__construct($view, $flash);
    }

    /**
     * @throws InvalidSelectorException
     */
    public function create(Request $request, Response $response, array $args): Response
    {
        $urlId = (int) $args['url_id'];
        $routeParser = $this->getRouteParser($request);
        $redirectUrl = $routeParser->urlFor('urls.show', ['id' => (string) $urlId]);

        if (!$urlId) {
            $this->addFlash('danger', 'Некорректный ID URL');
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $check = $this->urlCheckerService->checkUrlById($urlId);

        if (!$check) {
            $this->addFlash('danger', 'Произошла ошибка при проверке, не удалось подключиться');
            return $response
                ->withHeader('Location', $redirectUrl)
                ->withStatus(302);
        }

        $this->checkRepository->save($check);
        $this->addFlash('success', 'Страница успешно проверена');

        return $response
            ->withHeader('Location', $redirectUrl)
            ->withStatus(302);
    }
}
