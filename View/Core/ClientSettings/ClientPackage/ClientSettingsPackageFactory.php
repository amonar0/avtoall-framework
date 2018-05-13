<?php

namespace AutoAlliance\View\Core\ClientSettings\ClientPackage;

use AutoAlliance\ClientPackage\Core\Factory\InPlaceSelfClientPackageFactory;
use AutoAlliance\ClientPackage\Core\Factory\InPlaceClassClientPackageFactory;
use AutoAlliance\View\Core\ClientSettings\Container\ContainerInterface;
use AutoAlliance\ClientPackage\Core\ClientPackage;
use AutoAlliance\ClientPackage\CorePackage\CorePackageFactory;

final class ClientSettingsPackageFactory extends InPlaceSelfClientPackageFactory
{

    /**
     * @var InPlaceClassClientPackageFactory
     */
    private $inPlaceClassFactory;
    /**
     * @var CorePackageFactory
     */
    private $coreFactory;
    /**
     * @var ContainerInterface
     */
    private $settingsContainer;

    public function __construct(
        InPlaceClassClientPackageFactory $inPlaceClassFactory,
        CorePackageFactory $coreFactory,
        ContainerInterface $settingsContainer
    ) {
        parent::__construct($inPlaceClassFactory);
        $this->inPlaceClassFactory = $inPlaceClassFactory;
        $this->coreFactory = $coreFactory;
        $this->settingsContainer = $settingsContainer;
    }

    public function create(): ClientPackage
    {
        $selfPackage = parent::create()
            ->addDependencies($this->coreFactory->create());

        return $this->inPlaceClassFactory->create(get_class($this->settingsContainer))
            ->addDependencies($selfPackage);
    }
}