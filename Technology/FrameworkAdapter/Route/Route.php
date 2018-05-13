<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Route;

use AutoAlliance\Controller\Core\ControllerClass;

final class Route
{
    /**
     * @var ControllerClass
     */
    private $controllerClass;

    /**
     * @var string
     */
    private $uriDelimiter;
    /**
     * @var string
     */
    private $frontControllerId;

    public function __construct(
        ControllerClass $controllerClass,
        string $uriDelimiter,
        string $frontControllerId
    ) {
        $this->controllerClass = $controllerClass;
        $this->uriDelimiter = $uriDelimiter;
        $this->frontControllerId = $frontControllerId;
    }

    public function uri(): string
    {
        $path = $this->controllerClass->relativePath();

        $id = str_replace(DIRECTORY_SEPARATOR, $this->uriDelimiter, $path);
        $id = '/' . $id;

        $delimiter = preg_quote($this->uriDelimiter);
        $id = preg_replace_callback_array([
            "|[/$delimiter][A-Z]|" => function (array $matches) {
                return strtolower($matches[0]);
            },
            '|(?<=[^/A-Z])[A-Z]|' => function (array $matches) {
                return '-' . strtolower($matches[0]);
            },
        ], $id);

        return $id;
    }

    public function route(): string
    {
        return $this->frontControllerId . '/' . $this->controllerClass->id();
    }
}