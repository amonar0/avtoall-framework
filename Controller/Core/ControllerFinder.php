<?php

namespace AutoAlliance\Controller\Core;

use AutoAlliance\Technology\Common\AnyClassFactory;
use AutoAlliance\Technology\Common\ClassFinder;
use AutoAlliance\Technology\FileSystem\File\Directory;

final class ControllerFinder
{
    /**
     * @var Directory
     */
    private $controllersBasePath;
    /**
     * @var ClassFinder
     */
    private $classFinder;
    /**
     * @var AnyClassFactory
     */
    private $factory;

    public function __construct(
        Directory $controllersBasePath,
        ClassFinder $classFinder,
        AnyClassFactory $anyFactory
    ) {
        $this->controllersBasePath = $controllersBasePath;
        $this->classFinder = $classFinder;
        $this->factory = $anyFactory;
    }

    /**
     * @return ControllerClass[]
     */
    public function findAll(): array
    {
        $classes = $this->classFinder->find($this->controllersBasePath, '|^(?!.*/Core/).*Controller\.php$|');

        return array_map(function (\ReflectionClass $class) {
            return $this->factory->create(ControllerClass::class, [$class->getName()]);
        }, $classes);
    }
}