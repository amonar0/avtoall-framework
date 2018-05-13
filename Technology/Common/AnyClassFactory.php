<?php

namespace AutoAlliance\Technology\Common;


use AutoAlliance\Technology\Php\Reflection\ReflectionMethodHelper;
use DI\FactoryInterface;
use AutoAlliance\Technology\Helper\Assert;

//@todo как оказалось, этот класс по сути Service Locator
//нужно заменить его использование на конкретные фабрики везде, чтобы был нормальный SOLID
final class AnyClassFactory
{

    /**
     * @var FactoryInterface $factory
     */
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function create(string $class, array $parameters = [], string $baseClass = '')
    {
        if ($baseClass) {
            Assert::successorsOf($baseClass, $class);
        }

        $constructor = (new \ReflectionClass($class))->getConstructor();
        $namedParameters = ReflectionMethodHelper::namedParameters($constructor, ...$parameters);

        return $this->factory->make($class, $namedParameters);
    }
}