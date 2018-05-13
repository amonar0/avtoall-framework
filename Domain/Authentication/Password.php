<?php

namespace AutoAlliance\Domain\Authentication;

final class Password
{
    /**
     * @var string
     */
    private $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->password;
    }
}