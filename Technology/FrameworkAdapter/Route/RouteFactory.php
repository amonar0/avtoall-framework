<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Route;

use AutoAlliance\Controller\Core\Controller;
use AutoAlliance\Controller\Core\ControllerClass;
use AutoAlliance\Technology\Common\AnyClassFactory;

final class RouteFactory
{
    /**
     * @var string
     */
    private $uriDelimiter;
    /**
     * @var string
     */
    private $frontControllerId;
    /**
     * @var AnyClassFactory
     */
    private $factory;


    public function __construct(
        string $uriDelimiter,
        string $frontControllerId,
        AnyClassFactory $factory
    ) {
        $this->uriDelimiter = $uriDelimiter;
        $this->frontControllerId = $frontControllerId;
        $this->factory = $factory;
    }

    public function create($controllerClass): Route
    {
        if (!$controllerClass instanceof ControllerClass) {
            $controllerClass = $this->factory->create(Controller::class, [$controllerClass]);
        }

        return $this->factory->create(Route::class, [
            $controllerClass,
            $this->uriDelimiter,
            $this->frontControllerId,
        ]);
    }
}