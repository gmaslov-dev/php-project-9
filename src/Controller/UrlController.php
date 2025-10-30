<?php

namespace Hexlet\Code\Controller;

use Hexlet\Code\Repository\UrlRepository;
use Hexlet\Code\Service\CheckService;
use Hexlet\Code\Service\UrlCheckService;
use Hexlet\Code\Validator\UrlValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Http\ServerRequest;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Hexlet\Code\Entity\Url;
use Slim\Flash\Messages;

class UrlController extends BaseController
{
    public function __construct(
        Twig $view,
        Messages $flash,
        protected UrlRepository $urlRepository,
        protected CheckService $checkService,
        protected UrlCheckService $urlCheckService
    ) {
        parent::__construct($view, $flash);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        $urlsWithLastCheck = $this->urlCheckService->getUrlsWithLastCheck();

        return $this->render($response, 'urls/index.twig', [
            'current_path' => $request->getUri()->getPath(),
            'urls' => $urlsWithLastCheck,
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function create(ServerRequest $request, Response $response): Response
    {
        $routeParser = $this->getRouteParser($request);
        $urlData = $request->getParsedBodyParam("url");
        $errors = UrlValidator::validate($urlData);
        if (!$errors) {
            $url = $this->urlRepository->findByName($urlData['name']);
            if ($url) {
                $this->addFlash('success', 'Страница уже существует');
            } else {
                $url = Url::fromArray(['name' => $urlData['name']]);
                $this->urlRepository->save($url);
                $this->addFlash('success', 'Страница успешно добавлена');
            }

            $urlPath = $routeParser->urlFor('urls.show', ['id' => (string) $url->getId()]);
            return $response
                ->withHeader('Location', $urlPath)
                ->withStatus(302);
        }

        $params = [
            'title' => 'Главная страница',
            'url' => $urlData,
            'errors' => $errors,
        ];
        return $this->render($response, '/pages/index.twig', $params)->withStatus(422);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $url = $this->urlRepository->findById($id);
        if (!$url) {
            return throw new HttpNotFoundException($request);
        }

        $checks = $this->checkService->getChecksForUrl($id);

        $data = [
            'title' => $url->getName(),
            'url' => $url,
            'messages' => $this->flash->getMessages(),
            'checks' => $checks,
        ];
        return $this->render($response, 'urls/show.twig', $data);
    }
}
