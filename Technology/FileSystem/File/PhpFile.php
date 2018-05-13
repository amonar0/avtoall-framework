<?php

namespace AutoAlliance\Technology\FileSystem\File;

final class PhpFile extends File
{

    public function __construct(string $existingPhpFile)
    {
        parent::__construct($existingPhpFile);

        assert($this->hasExtension('php'));
    }

    public function result()
    {
        return require $this->getRealPath();
    }
}
