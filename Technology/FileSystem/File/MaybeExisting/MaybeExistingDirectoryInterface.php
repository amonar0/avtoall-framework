<?php

namespace AutoAlliance\Technology\FileSystem\File\MaybeExisting;

use AutoAlliance\Technology\FileSystem\File\File;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingFileInterface;

interface MaybeExistingDirectoryInterface extends MaybeExistingFileInterface
{
    /**
     * @param string $regexpPattern
     * @return File[]
     */
    public function findRecursively(string $regexpPattern): array;

    /**
     *
     * @param string[] $patterns
     * @return File[]
     */
    public function glob(string ...$patterns): array;
}