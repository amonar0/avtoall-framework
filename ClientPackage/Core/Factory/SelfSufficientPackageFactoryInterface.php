<?php

namespace AutoAlliance\ClientPackage\Core\Factory;

use AutoAlliance\ClientPackage\Core\ClientPackage;

interface SelfSufficientPackageFactoryInterface
{

    public function create(): ClientPackage;
}
