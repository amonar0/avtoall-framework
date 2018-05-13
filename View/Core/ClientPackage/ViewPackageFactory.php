<?php

namespace AutoAlliance\View\Core\ClientPackage;

use AutoAlliance\ClientPackage\Core\Factory\InPlaceClassClientPackageFactory;
use AutoAlliance\ClientPackage\Core\ClientPackage;
use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;
use AutoAlliance\View\Core\ClientSettings\ClientPackage\ClientSettingsPackageFactory;
use AutoAlliance\Technology\FileSystem\SelectFilesInDirectoryStragegyInterface;
use AutoAlliance\ClientPackage\CorePackage\CorePackageFactory;
use AutoAlliance\ClientPackage\Core\Factory\SelfSufficientPackageFactoryInterface;

abstract class ViewPackageFactory implements SelfSufficientPackageFactoryInterface, ViewPackageFactoryInterface
{

    /**
     * @var SelectFilesInDirectoryStragegyInterface
     */
    private $selectFilesStrategy;
    /**
     * @var CorePackageFactory
     */
    private $coreFactory;
    /**
     * @var InPlaceClassClientPackageFactory
     */
    private $inPlaceClassFactory;
    /**
     * @var ClientSettingsPackageFactory
     */
    private $clientSettingsFactory;

    public function __construct(
        SelectFilesInDirectoryStragegyInterface $selectFilesStrategy,
        CorePackageFactory $coreFactory,
        InPlaceClassClientPackageFactory $inPlaceClassFactory,
        ClientSettingsPackageFactory $clientSettingsFactory
    ) {
        $this->selectFilesStrategy = $selectFilesStrategy;
        $this->coreFactory = $coreFactory;
        $this->inPlaceClassFactory = $inPlaceClassFactory;
        $this->clientSettingsFactory = $clientSettingsFactory;
    }

    public function clientApi(string $methodCall): string
    {
        return sprintf('alliance.view.%s.%s', $this->id(), $methodCall);
    }

    public function create(): ClientPackage
    {
        $selfDirectory = ReflectionClassHelper::baseDirectory(static::class);
        $files = $this->selectFilesStrategy->select($selfDirectory);

        $baseViewPackage = $this->inPlaceClassFactory->create(self::class)
            ->addDependencies(
                $this->clientSettingsFactory->create(),
                $this->coreFactory->create()
            );

        return new ClientPackage($this->id(), $files, $baseViewPackage);
    }

    public function id(): string
    {
        $class = ReflectionClassHelper::onlyClassName(static::class);
        $class = preg_replace('/PackageFactory$/', '', $class);
        $class = lcfirst($class);

        return $class;
    }
}