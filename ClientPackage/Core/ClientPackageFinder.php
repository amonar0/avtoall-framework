<?php

namespace AutoAlliance\ClientPackage\Core;

use AutoAlliance\Technology\Common\ClassFinder;
use AutoAlliance\Technology\FileSystem\File\Directory;

final class ClientPackageFinder
{
    /**
     * @var Directory
     */
    private $clientPackagesBasePath;
    /**
     * @var Directory
     */
    private $viewsBasePath;
    /**
     * @var ClassFinder
     */
    private $classFinder;

    public function __construct(
        Directory $clientPackagesBasePath,
        Directory $viewsBasePath,
        ClassFinder $classFinder
    ) {
        $this->clientPackagesBasePath = $clientPackagesBasePath;
        $this->viewsBasePath = $viewsBasePath;
        $this->classFinder = $classFinder;
    }

    /**
     * @return \ReflectionClass[]
     */
    public function findAll(): array
    {
        return array_merge(
            $this->findInDirectory($this->clientPackagesBasePath),
            $this->findInDirectory($this->viewsBasePath)
        );
    }

    /**
     * @param Directory $baseDirectory
     * @return \ReflectionClass[]
     */
    public function findInDirectory(Directory $baseDirectory): array
    {
        return $this->classFinder->find($baseDirectory, '|^(?!.*/Core/).*PackageFactory\.php$|');
    }
}