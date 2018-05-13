<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Interfaces;

use AutoAlliance\ClientPackage\Core\ClientPackage;

/**
 * @author amonar
 * @see ClientScript
 */
interface ClientScriptManagerInterface
{

    public function registerPackages(ClientPackage $package, ClientPackage ...$packages): self;
}
