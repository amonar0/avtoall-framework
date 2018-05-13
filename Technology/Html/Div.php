<?php

namespace AutoAlliance\Technology\Html;

use AutoAlliance\Technology\Html\Tag;

final class Div extends Tag
{

    public function __construct($contents, $classes = [], array $attributes = [])
    {
        parent::__construct('div', $contents, $classes, $attributes);
    }
}
