<?php

namespace AutoAlliance\ClientPackage\Core\Factory;

use AutoAlliance\ClientPackage\Core\ClientPackage;
use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;

class InPlaceClassClientPackageFactory
{

    /**
     * @var DirectoryClientPackageFactory $directoryFactory
     */
    private $directoryFactory;

    public function __construct(DirectoryClientPackageFactory $factory)
    {
        $this->directoryFactory = $factory;
    }

    public function create(string $class): ClientPackage
    {
        $directory = ReflectionClassHelper::baseDirectory($class);

        return $this->directoryFactory->create($directory, $this->createId($class));
    }

    private function createId(string $class): string
    {
        $class = ReflectionClassHelper::onlyClassName($class);
        $id = preg_replace('/Factory$/', '', $class);
        $id = preg_replace('/Package$/', '', $id);

        return $id;
    }
}
