<?php

namespace AutoAlliance\Technology\FileSystem\File\MaybeExisting;

use AutoAlliance\Technology\FileSystem\File\File;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingDirectoryInterface;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingFile;

final class MaybeExistingDirectory extends MaybeExistingFile implements MaybeExistingDirectoryInterface
{

    /**
     * @param string $regexpPattern
     * @return File[]
     */
    public function findRecursively(string $regexpPattern): array
    {
        return [];
    }

    /**
     *
     * @param string[] $patterns
     * @return File[]
     */
    public function glob(string ...$patterns): array
    {
        return [];
    }
}