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

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function create(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $urlData = $request->getParsedBodyParam("url");
        $errors = UrlValidator::validate($urlData);
        if (!$errors) {
            $url = $this->urlRepository->findByName($urlData['name']);
            if ($url) {
                $this->flash->addMessage('success', 'Страница уже существует');
            } else {
                $url = Url::fromArray(['name' => $urlData['name'], 'created_at' => $urlData['created_at']]);
                $this->urlRepository->save($url);
                $this->flash->addMessage('success', 'Страница добавлена');
            }

            $urlPath = $routeParser->urlFor('urls.show', ['id' => $url->getId()]);
            return $response
                ->withHeader('Location', $urlPath)
                ->withStatus(302);
        }

        $params = [
            'title' => 'Главная страница',
            'url' => $urlData,
            'errors' => $errors,
        ];
        dump($params);
        return $this->view->render($response, '/pages/index.twig', $params)->withStatus(422);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $id = $args['id'];
        $url = $this->urlRepository->find($id);
        if (!$url) {
            return $response->withRedirect($routeParser->urlFor('home'), 302);
        }

        $data = [
            'title' => $url->getName(),
            'url' => $url,
            'messages' => $this->flash->getMessages(),
        ];
        return $this->view->render($response, 'urls/show.twig', $data);
    }
}
