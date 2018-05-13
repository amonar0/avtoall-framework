<?php

namespace AutoAlliance\ClientPackage\Core;

use AutoAlliance\Technology\FileSystem\File\ClientFile;
use AutoAlliance\Technology\Helper\Assert;

class ClientPackage implements ClientPackageDependencyInterface
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var array|ClientFile[]
     */
    private $files;
    /**
     * @var ClientPackageDependencyInterface[]
     */
    private $dependencies;

    /**
     * @param string $id
     * @param ClientFile[] $files
     * @param ClientPackageDependencyInterface[] $dependencies
     */
    public function __construct(
        string $id,
        array $files,
        ClientPackageDependencyInterface ...$dependencies
    ) {
        Assert::instancesOf(ClientFile::class, ...$files);

        $this->id = $id;
        $this->files = $files;
        $this->dependencies = $dependencies;
    }

    final public function addJs(ClientFile ...$files): self
    {
        $files = array_merge($this->files, $files);

        return new self($this->id, $files, ...$this->dependencies);
    }

    final public function addDependencies(ClientPackageDependencyInterface ...$dependencies): self
    {
        $dependencies = array_merge($this->dependencies, $dependencies);

        return new self($this->id, $this->files, ...$dependencies);
    }

    final public function id(): string
    {
        return $this->id;
    }

    /**
     *
     * @return ClientFile[]
     */
    final public function files(): array
    {
        return $this->files;
    }

    final public function dependencies(): array
    {
        return $this->dependencies;
    }
}
