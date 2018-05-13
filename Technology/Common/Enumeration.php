<?php

namespace AutoAlliance\Technology\Common;

use AutoAlliance\Technology\Helper\Output;

abstract class Enumeration
{

    /**
     * @var mixed $value
     */
    private $value;

    public function __construct($value)
    {
        assert(is_scalar($value), $value);
        $this->assertHasConstantWithValue($value);

        $this->value = $value;
    }

    public function equal($enumeration): bool
    {
        $baseClass = $this->equalityBaseClass();
        assert($enumeration instanceof $baseClass,
            Output::sprintf('%s, %s', $enumeration, $baseClass));

        return (string)$this === (string)$enumeration;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    protected function equalityBaseClass(): string
    {
        return static::class;
    }

    private function assertHasConstantWithValue($value)/*: void*/
    {
        static $values = [];
        $class = static::class;

        if (!isset($values[$class])) {
            $reflection = new \ReflectionClass($this);
            $values[$class] = array_flip($reflection->getConstants());
        }

        assert(isset($values[$class][$value]),
            Output::sprintf('%s %s %s', $class, $value, $values));
    }
}