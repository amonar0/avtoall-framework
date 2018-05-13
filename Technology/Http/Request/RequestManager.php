<?php

namespace AutoAlliance\Technology\Http\Request;

use AutoAlliance\Controller\Core\ControllerClass;
use AutoAlliance\Technology\Http\Request\Uri;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\FrameworkUriCreatorInterface;
use AutoAlliance\Technology\Http\Request\QueryParameter\QueryParameterInterface;
use AutoAlliance\Technology\Http\Exception\UnprocessableEntityHttpException;
use AutoAlliance\Technology\Http\Request\QueryMethod\Get;
use AutoAlliance\Technology\Http\Request\Fragment;
use AutoAlliance\Technology\Helper\Lists;
use AutoAlliance\Technology\FrameworkAdapter\Route\RouteFactory;

final class RequestManager implements UriCreatorInterface
{

    /**
     * @var FrameworkUriCreatorInterface
     */
    private $uriCreator;
    /**
     * @var RouteFactory
     */
    private $routeFactory;

    public function __construct(FrameworkUriCreatorInterface $uriCreator, RouteFactory $routeFactory)
    {
        $this->uriCreator = $uriCreator;
        $this->routeFactory = $routeFactory;
    }

    public function parameter(string $parameterClass)
    {
        /* @var $parameter QueryParameterInterface */
        $parameter = new $parameterClass();

        assert($parameter instanceof QueryParameterInterface);

        $data = $parameter->accessData();

        if ($data === null) {
            return null;
        }

        if (!$parameter->validFor($data)) {
            $message = sprintf('Query parameter "%s" has not valid data: %s', $parameterClass, $data);
            throw new UnprocessableEntityHttpException($message);
        }

        return $data;
    }

    //@todo проверка, что все неопциональные параметры контроллера задействованы
    public function createParametersQuery(array $parameters, string $fragmentClass = ''): array
    {
        $queryParameters = [];

        foreach ($parameters as $class => $data) {
            /* @var $parameter QueryParameterInterface */
            $parameter = new $class();

            assert($parameter->validFor($data), is_array($data) ? Lists::toString($data) : $data);
            assert($parameter->method() instanceof Get);

            $queryParameters[$parameter->key()] = $data;
        }

        if ($fragmentClass) {
            /* @var $fragment Fragment */
            $fragment = new $fragmentClass();
            $queryParameters['#'] = $fragment->key();
        }

        return $queryParameters;
    }

    public function uri(string $controllerClass, array $parameters = [], string $fragmentClass = ''): Uri
    {
        $route = $this->routeFactory->create($controllerClass)->route();
        $params = $this->createParametersQuery($parameters, $fragmentClass);

        return $this->uriCreator->createUri($route, $params);
    }

    public function frameworkUri(string $route, array $queryParameters = []): Uri
    {
        return $this->uriCreator->createUri($route, $queryParameters);
    }

    public function uriFragment(string $fragmentClass): Uri
    {
        return new Uri('#' . $this->anchor($fragmentClass));
    }

    public function anchor(string $fragmentClass): string
    {
        return (new $fragmentClass())->key();
    }
}