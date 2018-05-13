<?php

namespace AutoAlliance\Technology\Http\Request;

interface UriCreatorInterface
{

    public function uri(string $controllerClass, array $parameters = [], string $fragmentClass = ''): Uri;

    public function frameworkUri(string $route, array $queryParameters = []): Uri;

    public function uriFragment(string $fragmentClass): Uri;

    public function anchor(string $fragmentClass): string;

    public function createParametersQuery(array $parameters, string $fragmentClass = ''): array;
}
