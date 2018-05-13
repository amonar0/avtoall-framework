<?php

namespace AutoAlliance\Technology\FileSystem\File\MaybeExisting;

use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingDirectoryInterface;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingFile;
use AutoAlliance\Technology\Php\NativeInterface\SplFileInfoInterface;

interface MaybeExistingFileInterface extends SplFileInfoInterface
{
    /**
     * @param MaybeExistingFile|string $path
     * @return MaybeExistingFile
     */
    public function addPath($path): MaybeExistingFile;

    /**
     * @param MaybeExistingDirectoryInterface|string $directory
     * @return MaybeExistingDirectoryInterface
     */
    public function addDirectory($directory): MaybeExistingDirectoryInterface;

    public function equal(self $file): bool;

    public function hasExtension(string $extension): bool;
}