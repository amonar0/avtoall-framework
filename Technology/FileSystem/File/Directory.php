<?php

namespace AutoAlliance\Technology\FileSystem\File;

use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingDirectoryInterface;
use AutoAlliance\Technology\Helper\Assert;

class Directory extends File implements MaybeExistingDirectoryInterface
{

    public function __construct(string $existingDirectory)
    {
        assert(FileAssertion::isDir($existingDirectory), $existingDirectory);

        parent::__construct($existingDirectory);
    }

    //test

    /**
     * @param string $regexpPattern
     * @return File[]
     */
    final public function findRecursively(string $regexpPattern): array
    {
        $iterator = new \RecursiveDirectoryIterator($this->getRealPath());
        $iterator = new \RecursiveIteratorIterator($iterator);
        $iterator = new \RegexIterator($iterator, $regexpPattern);

        $files = iterator_to_array($iterator, false);
        $files = array_map(function (\SplFileInfo $file) {
            return new File($file->getPathname());
        }, $files);

        return $files;
    }

    /**
     *
     * @param string[] $patterns
     * @return File[]
     */
    final public function glob(string ...$patterns): array
    {
        $files = [];

        foreach ($patterns as $pattern) {
            $files = array_merge($files, $this->proceedGlob($pattern));
        }

        Assert::instancesOf(File::class, ...$files);

        return $files;
    }

    private function proceedGlob(string $pattern): array
    {
        $pattern = sprintf('%s%s%s', $this->getRealPath(), DIRECTORY_SEPARATOR, $pattern);
        $files = glob($pattern);

        assert($files !== false, sprintf('Pattern for function "glob" is incorrect: ', $pattern));

        return array_map(function ($filePath) {
            return new File($filePath);
        }, $files);
    }
}