<?php

namespace AutoAlliance\ClientPackage\Core;

use AutoAlliance\Technology\FileSystem\File\ClientFile;

interface ClientPackageDependencyInterface
{

    public function id(): string;

    /**
     *
     * @return ClientFile[]
     */
    public function files(): array;

    /**
     *
     * @return ClientPackageDependencyInterface[]
     */
    public function dependencies(): array;
}