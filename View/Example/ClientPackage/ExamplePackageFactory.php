<?php

namespace AutoAlliance\View\Example\ClientPackage;

use AutoAlliance\View\Core\ClientPackage\ViewPackageFactory;
use AutoAlliance\ClientPackage\Core\CoreDependency;
use AutoAlliance\ClientPackage\Core\ClientPackage;

final class ExamplePackageFactory extends ViewPackageFactory
{

    public function create(): ClientPackage
    {
        return parent::create()
            ->addDependencies(...CoreDependency::create('jstree'));
    }
}
