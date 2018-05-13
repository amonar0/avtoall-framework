<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Interfaces;

/**
 * @author amonar
 * @see Theme
 */
interface ThemeInterface
{

    public function isDefault(): bool;

    public function getName(): string;
}
