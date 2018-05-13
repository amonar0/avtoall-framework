<?php

namespace AutoAlliance\View\Core\ClientPackage;

final class NullPackageFactory implements ViewPackageFactoryInterface
{


    public function id(): string
    {
        return '';
    }

    public function clientApi(string $methodCall): string
    {
        assert(false, 'Package factory is not exist when try to call "clientApi" method');
    }
}