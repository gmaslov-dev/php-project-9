<?php

namespace Hexlet\Code\Controller;

use Hexlet\Code\Repository\UrlRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Valitron\Validator;
use Hexlet\Code\Entity\Url;
use Carbon\Carbon;
use Slim\Flash\Messages;

class UrlController
{
    public function __construct(
        protected Twig $view,
        protected UrlRepository $urlRepository,
        protected Messages $flash
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'urls/index.twig', [
            'urls' => $this->urlRepository->getEntities(),
        ]);
    }

    public function create(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $urlData = $request->getParsedBodyParam("url");
        $v = new Validator($urlData);
        $v->rules(['required' => ['name'],
            'lengthMax' => [['name', 255]],
            'url' => ['name']]);
        $v->validate();
        $errors = $v->errors();

        if (!$errors) {
            if ($this->urlRepository->findByName($urlData['name'])) {
                $this->flash->addMessage('success', 'Страница уже существует');
            } else {
                $createdAt = Carbon::now()->toDateTimeString();
                $url = Url::fromArray([
                    'name' => $urlData['name'],
                    'created_at' => $createdAt
                ]);
                $this->urlRepository->save($url);
                $this->flash->addMessage('success', 'Страница добавлена');
            }

            return $response->withRedirect($routeParser->urlFor('home'), 302);
        }

        $params = [
            'url' => $urlData,
            'errors' => $errors,
        ];
        return $this->view->render($response, '/pages/index.twig', $params);
    }
}
