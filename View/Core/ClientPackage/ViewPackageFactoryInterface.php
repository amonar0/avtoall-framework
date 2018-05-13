<?php

namespace AutoAlliance\View\Core\ClientPackage;


interface ViewPackageFactoryInterface
{
    public function id(): string;

    public function clientApi(string $methodCall): string;

}