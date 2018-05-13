<?php

namespace AutoAlliance\Technology\Php;

final class CodeSentenceExtractor
{
    public function namespace_(string $source): string
    {
        return $this->namespaceRegexpPattern()->matchSingleSurely($source);
    }

    public function onlyClass(string $source): string
    {
        return $this->classRegexpPattern()->matchSingleSurely($source);
    }

    public function fullClass(string $source): \ReflectionClass
    {
        $class = $this->namespace_($source) . '\\' . $this->onlyClass($source);

        return new \ReflectionClass($class);
    }

    private function namespaceRegexpPattern(): Regexp
    {
        $subNamespace = $this->entityRegexpPattern();
        $namespace = "$subNamespace(?:\\\\$subNamespace)*";

        return new Regexp("/namespace\s+($namespace)\s*;/");
    }

    private function classRegexpPattern(): Regexp
    {
        $classPattern = $this->entityRegexpPattern();

        return new Regexp("/class\s+($classPattern)\s+/");
    }

    private function entityRegexpPattern(): string
    {
        $firstLetter = 'a-zA-Z_\x7f-\xff';
        $letter = "{$firstLetter}0-9";

        return "[$firstLetter][$letter]*";
    }
}
