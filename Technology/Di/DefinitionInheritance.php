<?php

namespace AutoAlliance\Technology\Di;

use DI\Definition\Source\DefinitionSource;
use DI\Definition\Source\DefinitionArray;
use DI\Definition\ObjectDefinition\MethodInjection;
use DI\Definition\Helper\ObjectDefinitionHelper;
use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;
use AutoAlliance\Technology\Php\Reflection\ReflectionParameterHelper;
use AutoAlliance\Technology\Helper\Psr;

final class DefinitionInheritance implements DefinitionSource
{

    /**
     * @var DefinitionArray $definition
     */
    private $definition;

    /**
     * @var array $source
     */
    private $source;

    public function __construct(DefinitionArray $definition, array $source)
    {
        $this->definition = $definition;
        $this->source = $source;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefinition($name)
    {
        if (!Psr::isClassName($name) || !class_exists($name)) {
            return null;
        }

        $class = new \ReflectionClass($name);
        $ancestors = $this->getAllAncestors($class, $this->source);

        if (!$ancestors) {
            return null;
        }

        $ancestor = ReflectionClassHelper::findClosestAncestor($class, ...$ancestors);
        $ancestorInjections = $this->associateParametersWithInjections($this->definition
            ->getDefinition($ancestor->getName())
            ->getConstructorInjection(), ...$ancestor->getConstructor()->getParameters());

        $definitionHelper = new ObjectDefinitionHelper();
        $existDefinition = false;

        foreach ($class->getConstructor()->getParameters() as $parameter) {
            /* @var $parameter \ReflectionParameter */
            if (ReflectionParameterHelper::isInheritedFromClass($parameter, $ancestor)
                && isset($ancestorInjections[$parameter->getName()])) {
                $existDefinition = true;
                $definitionHelper->constructorParameter($parameter->getName(),
                    $ancestorInjections[$parameter->getName()]);
            }
        }

        return $existDefinition ? $definitionHelper->getDefinition($name) : null;
    }

    /**
     * @param \ReflectionClass $class
     * @param array $source
     * @return \ReflectionClass[]
     */
    private function getAllAncestors(\ReflectionClass $class, array $source): array
    {
        $sourceClasses = array_keys($source);

        $ancestorClasses = array_filter($sourceClasses, function (string $maybeParent) use ($class) {
            return is_subclass_of($class->getName(), $maybeParent) &&
                !array_key_exists($maybeParent, class_implements($class->getName()));
        });

        $reflections = array_map(function (string $class) {
            return new \ReflectionClass($class);
        }, $ancestorClasses);

        return $reflections;
    }

    private function associateParametersWithInjections(
        MethodInjection $injection,
        \ReflectionParameter ...$parameters
    ): array {
        $injectionParameters = $injection->getParameters();
        $storage = [];

        foreach ($parameters as $parameter) {
            if (array_key_exists($parameter->getPosition(), $injectionParameters)) {
                $storage[$parameter->getName()] = $injectionParameters[$parameter->getPosition()];
            }
        }

        return $storage;
    }
}