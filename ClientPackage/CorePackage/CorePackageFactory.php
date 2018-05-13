<?php

namespace AutoAlliance\ClientPackage\CorePackage;

use AutoAlliance\ClientPackage\Core\ClientPackage;
use AutoAlliance\ClientPackage\Core\Factory\InPlaceSelfClientPackageFactory;
use AutoAlliance\ClientPackage\Core\Factory\InPlaceClassClientPackageFactory;
use AutoAlliance\ClientPackage\Vendor\Underscore\UnderscorePackageFactory;

final class CorePackageFactory extends InPlaceSelfClientPackageFactory
{
    /**
     * @var UnderscorePackageFactory $underscoreFactory
     */
    private $underscoreFactory;

    public function __construct(InPlaceClassClientPackageFactory $factory, UnderscorePackageFactory $underscoreFactory)
    {
        parent::__construct($factory);
        $this->underscoreFactory = $underscoreFactory;
    }

    public function create(): ClientPackage
    {
        return parent::create()
            ->addDependencies($this->underscoreFactory->create());
    }
}
