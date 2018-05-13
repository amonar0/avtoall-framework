<?php

namespace AutoAlliance\View\Core;

use AutoAlliance\Technology\Common\AnyClassFactory;
use AutoAlliance\View\Core\View;
use AutoAlliance\Technology\Common\PresenterFactoryInterface;
use AutoAlliance\Technology\Common\PresenterInterface;

final class ViewFactory implements PresenterFactoryInterface
{

    /**
     * @var AnyClassFactory $factory
     */
    private $factory;

    public function __construct(AnyClassFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(string $viewClass, ...$parameters): PresenterInterface
    {
        return $this->factory->create($viewClass, $parameters, View::class);
    }
}
