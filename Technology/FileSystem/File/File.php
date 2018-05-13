<?php

namespace AutoAlliance\Technology\FileSystem\File;

use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingFile;
use AutoAlliance\Technology\Helper\OS;

class File extends MaybeExistingFile
{

    public function __construct(string $existingFile)
    {
        assert(FileAssertion::isFile($existingFile) || FileAssertion::isDir($existingFile), $existingFile);

        parent::__construct($existingFile);
    }

    //@test
    final public function commonBaseDirectory(self $file, self ...$files): Directory
    {
        assert($this->inUnixFileSystem());

        $files = array_merge([$file], $files);

        $directories = array_map(function (self $file) {
            return $file->baseDirectory();
        }, $files);

        $baseDirectory = $this->baseDirectory();

        foreach ($directories as $directory) {
            if ($directory->isParentDirectory($baseDirectory)) {
                $baseDirectory = $directory;
            }
        }

        return $baseDirectory;
    }

    //@test
    public function isParentDirectory(Directory $directory): bool
    {
        $parent = rtrim($directory->getRealPath(), '/');
        $child = rtrim($this->getRealPath(), '/');

        $parentParts = explode('/', $parent);
        $childParts = explode('/', $child);

        for ($i = 0; $i < count($parentParts); $i++) {
            if (!isset($childParts[$i])) {
                return true;
            }

            if ($parentParts[$i] != $childParts[$i]) {
                return false;
            }
        }

        return true;
    }

    //@test
    final public function relativePath(Directory $parentDirectory): MaybeExistingFile
    {
        assert($this->baseDirectory()->isParentDirectory($parentDirectory),
            sprintf('%s, %s', $this->baseDirectory(), $parentDirectory));

        $file = $this->getRealPath();
        $parent = $parentDirectory->getRealPath();

        $relativePath = str_replace($parent . DIRECTORY_SEPARATOR, '', $file);

        return new MaybeExistingFile($relativePath);
    }

    final public function baseDirectory(): Directory
    {
        return new Directory($this->getPath());
    }

    final public function content(): string
    {
        $fileObject = $this->fileObject();

        return $fileObject->fread($fileObject->getSize());
    }

    private $fileObject;

    private function fileObject(): \SplFileObject
    {
        if (!$this->fileObject) {
            $this->fileObject = $this->openFile();
        }

        return $this->fileObject;
    }

    private function inUnixFileSystem(): bool
    {
        return DIRECTORY_SEPARATOR === '/';
    }
}
