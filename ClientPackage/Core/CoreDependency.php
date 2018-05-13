<?php

namespace AutoAlliance\ClientPackage\Core;

final class CoreDependency implements ClientPackageDependencyInterface
{

    /**
     * @var string $id
     */
    private $id;

    /**
     *
     * @param type $ids
     * @return self[]
     */
    public static function create(string ...$ids): array
    {
        return array_map(function (string $id) {
            return new self($id);
        }, $ids);
    }

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function files(): array
    {
        return [];
    }

    public function dependencies(): array
    {
        return [];
    }
}
