<?php

namespace AutoAlliance\Technology\Php;

final class Regexp
{
    /**
     * @var string
     */
    private $pattern;

    public function __construct(string $validRegexpPattern)
    {
        $this->pattern = $validRegexpPattern;
    }

    public function matchSingleSurely(string $subject): string
    {
        $matches = [];
        $found = preg_match($this->pattern, $subject, $matches);

        assert($found);

        return $matches[1];
    }
}