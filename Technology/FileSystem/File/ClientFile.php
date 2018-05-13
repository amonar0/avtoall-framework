<?php

namespace AutoAlliance\Technology\FileSystem\File;

final class ClientFile extends File
{

    public function __construct(string $existingClientFile)
    {
        parent::__construct($existingClientFile);

        assert($this->hasExtension('js') || $this->hasExtension('css'));
    }
}