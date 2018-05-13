<?php

namespace AutoAlliance\Technology\Http\Request;

use AutoAlliance\Technology\FrameworkAdapter\Interfaces\FrameworkRedirectorInterface;
use AutoAlliance\Technology\FrameworkAdapter\Route\RouteFactory;

final class Redirector
{

    /**
     * @var FrameworkRedirectorInterface
     */
    private $frameworkRedirector;
    /**
     * @var RouteFactory
     */
    private $routeFactory;

    public function __construct(FrameworkRedirectorInterface $redirector, RouteFactory $routeFactory)
    {
        $this->frameworkRedirector = $redirector;
        $this->routeFactory = $routeFactory;
    }

    public function redirectToFrameworkController(array $routeAndParameters, int $statusCode = 302)//: void
    {
        return $this->frameworkRedirector->redirect($routeAndParameters, true, $statusCode);
    }

    public function redirect(string $controllerClass, int $statusCode = 302)//: void
    {
        $route = $this->routeFactory->create($controllerClass);

        return $this->redirectToFrameworkController($route, $statusCode);
    }

    public function redirectToUri(Uri $uri, int $statusCode = 302)//: void
    {
        return $this->frameworkRedirector->redirect((string) $uri, true, $statusCode);
    }
}