<?php

namespace AutoAlliance\ClientPackage\Core\Factory;

use AutoAlliance\ClientPackage\Core\ClientPackage;
use AutoAlliance\ClientPackage\Core\Factory\InPlaceClassClientPackageFactory;
use AutoAlliance\ClientPackage\Core\Factory\SelfSufficientPackageFactoryInterface;

class InPlaceSelfClientPackageFactory implements SelfSufficientPackageFactoryInterface
{

    /**
     * @var InPlaceClassClientPackageFactory $factory
     */
    private $factory;

    public function __construct(InPlaceClassClientPackageFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(): ClientPackage
    {
        return $this->factory->create(static::class);
    }
}
