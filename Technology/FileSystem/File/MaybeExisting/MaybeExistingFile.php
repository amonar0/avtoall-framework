<?php

namespace AutoAlliance\Technology\FileSystem\File\MaybeExisting;

use AutoAlliance\Technology\Common\CastableTrait;
use AutoAlliance\Technology\FileSystem\File\Directory;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingDirectory;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingDirectoryInterface;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingFileInterface;
use AutoAlliance\Technology\Helper\Lists;
use AutoAlliance\Technology\Php\NativeInterface\SplFileInfo;

class MaybeExistingFile extends \SplFileInfo implements MaybeExistingFileInterface
{
    use CastableTrait;

    /**
     * @param MaybeExistingFile|string $path
     * @return MaybeExistingFile
     */
    final public function addPath($path): self
    {
        assert(is_string($path) || $path instanceof self,
            print_r($path, true));

        if (is_string($path)) {
            $path = new self($path);
        }

        $file = $this->concatPaths($this, $path);

        return new self($file);
    }

    /**
     * @param MaybeExistingDirectoryInterface|string $directory
     * @return MaybeExistingDirectoryInterface
     */
    final public function addDirectory($directory): MaybeExistingDirectoryInterface
    {
        $fullDirectory = $this->addPath($directory);

        return $fullDirectory->isDir()
            ? Directory::cast($fullDirectory)
            : MaybeExistingDirectory::cast($fullDirectory);
    }

    final public function equal(MaybeExistingFileInterface $file): bool
    {
        return $this->getPathname() === $file->getPathname();
    }

    final public function hasExtension(string $extension): bool
    {
        return $this->getExtension() === $extension;
    }

    final public function basenameWithoutExtension(): string
    {
        return $this->getBasename(".{$this->getExtension()}");
    }

    final public function basenameWithoutAllExtensions(): string
    {
        return explode('.', $this->getBasename())[0];
    }

    protected function constructorValue()
    {
        return $this->getPathname();
    }

    private function concatPaths(self ...$paths): string
    {
        $strings = [];
        foreach ($paths as $path) {
            $strings[] = $path->getPathname();
            $strings[] = DIRECTORY_SEPARATOR;
        }
        // удалить последний лишний разделитель директорий
        array_pop($strings);

        return join('', $strings);
    }
}