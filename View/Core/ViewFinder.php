<?php

namespace AutoAlliance\View\Core;

use AutoAlliance\ClientPackage\Core\ClientPackageFinder;
use AutoAlliance\View\Core\ClientPackage\NullPackageFactory;
use AutoAlliance\Technology\Common\ClassFinder;
use AutoAlliance\Technology\FileSystem\File\Directory;
use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;

final class ViewFinder
{
    /**
     * @var Directory
     */
    private $viewsBasePath;
    /**
     * @var ClassFinder
     */
    private $classFinder;
    /**
     * @var ClientPackageFinder
     */
    private $clientPackageFinder;

    public function __construct(
        Directory $viewsBasePath,
        ClassFinder $classFinder,
        ClientPackageFinder $clientPackageFinder
    ) {
        $this->viewsBasePath = $viewsBasePath;
        $this->classFinder = $classFinder;
        $this->clientPackageFinder = $clientPackageFinder;
    }

    /**
     * @return \ReflectionClass[]
     */
    public function findAll(): array
    {
        return $this->classFinder->find($this->viewsBasePath, '|^(?!.*/Core/).*View\.php$|');
    }

    public function findClientPackage(\ReflectionClass $viewClass): \ReflectionClass
    {
        $viewDirectory = ReflectionClassHelper::baseDirectory($viewClass);
        $packages = $this->clientPackageFinder->findInDirectory($viewDirectory);

        if (!$packages) {
            $packages = [new \ReflectionClass(NullPackageFactory::class)];
        }

        $countPackages = count($packages);
        assert($countPackages <= 1, $countPackages);

        return $packages[0];
    }
}