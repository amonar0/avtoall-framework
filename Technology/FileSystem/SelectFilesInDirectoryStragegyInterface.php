<?php

namespace AutoAlliance\Technology\FileSystem;

use AutoAlliance\Technology\FileSystem\File\File;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingDirectoryInterface;

interface SelectFilesInDirectoryStragegyInterface
{
    /**
     * @param MaybeExistingDirectoryInterface $baseDirectory
     * @return File[]
     */
    public function select(MaybeExistingDirectoryInterface $baseDirectory): array;
}