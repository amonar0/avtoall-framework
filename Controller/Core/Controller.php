<?php

namespace AutoAlliance\Controller\Core;

use AutoAlliance\Technology\Common\AnyClassFactory;
use CController;
/** @uses Yii */

use AutoAlliance\Technology\FrameworkAdapter\Interfaces\RealActionInterface;
use AutoAlliance\Technology\Common\PresenterInterface;
use AutoAlliance\Technology\Common\PresenterFactoryInterface;

abstract class Controller implements PresenterInterface, RealActionInterface
{

    /**
     * @var PresenterFactoryInterface
     */
    private $presenterFactory;
    /**
     * @var AnyClassFactory
     */
    private $factory;
    /**
     * @var CController
     */
    private $controller;

    abstract public function present(): string;

    public function __construct(
        PresenterFactoryInterface $presenterFactory,
        AnyClassFactory $anyFactory,
        CController $controller
    ) {
        $this->presenterFactory = $presenterFactory;
        $this->factory = $anyFactory;
        $this->controller = $controller;
    }

    final public function getController(): CController
    {
        return $this->controller;
    }

    final public function getId(): string
    {
        return $this->class_()->id();
    }

    final public function runWithParams(array $params): bool
    {
        echo $this->present();

        return true;
    }

    final protected function presenterFactory(): PresenterFactoryInterface
    {
        return $this->presenterFactory;
    }

    private function class_(): ControllerClass
    {
        static $classes = [];

        $class = static::class;
        if (!isset($classes[$class])) {
            $classes[$class] = $this->factory->create(ControllerClass::class, [$class]);
        }

        return $classes[$class];
    }
}
