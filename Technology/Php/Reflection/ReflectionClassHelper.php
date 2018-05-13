<?php

namespace AutoAlliance\Technology\Php\Reflection;

use AutoAlliance\Technology\FileSystem\File\Directory;
use AutoAlliance\Technology\FileSystem\File\File;
use AutoAlliance\Technology\Helper\Lists;
use AutoAlliance\Technology\FileSystem\File\PhpFile;

final class ReflectionClassHelper
{

    //@test 
    public static function findClosestAncestor(
        \ReflectionClass $class,
        \ReflectionClass $ancestor,
        \ReflectionClass ... $ancestors
    ): \ReflectionClass {
        $ancestors = array_merge([$ancestor], $ancestors);

        assert(Lists::allItems($ancestors, function (\ReflectionClass $ancestor) use ($class) {
            return $class->isSubclassOf($ancestor->getName());
        }));

        /* @var $closestAncestor \ReflectionClass */
        $closestAncestor = array_pop($ancestors);
        $closestInheritanceDistance = self::inheritanceDistance($class, $closestAncestor);

        foreach ($ancestors as $ancestor) {
            $inheritanceDistance = self::inheritanceDistance($class, $ancestor);
            if ($inheritanceDistance < $closestInheritanceDistance) {
                $closestInheritanceDistance = $inheritanceDistance;
                $closestAncestor = $ancestor;
            }
        }

        return $closestAncestor;
    }

    private static function inheritanceDistance(\ReflectionClass $class, \ReflectionClass $ancestor): int
    {
        assert($class->isSubclassOf($ancestor));

        $distance = 0;

        while ($class !== null && $class->getParentClass()->getName() !== $ancestor->getName()) {
            $class = $class->getParentClass();
            $distance += 1;
        }

        return $distance;
    }

    public static function isSuccessor(\ReflectionClass $class, \ReflectionClass $ancestor): bool
    {
        return self::equal($class, $ancestor) || $class->isSubclassOf($ancestor->getName());
    }

    public static function equal(\ReflectionClass $class1, \ReflectionClass $class2): bool
    {
        return $class1->getName() === $class2->getName();
    }

    public static function onlyClassName($class): string
    {
        return self::create($class)->getShortName();
    }

    public static function baseDirectory($class): Directory
    {
        $class = self::create($class);
        $file = new File($class->getFileName());
        return $file->baseDirectory();
    }
    
    private static function create($class): \ReflectionClass
    {
        assert(is_string($class) || is_object($class));

        if (!$class instanceof \ReflectionClass) {
            $class = new \ReflectionClass($class);
        }

        return $class;
    }
}