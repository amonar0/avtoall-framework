<?php

namespace AutoAlliance\View\Core\RenderStrategy;

use AutoAlliance\View\Core\View;

interface RenderStrategyInterface
{

    public function render(View $view): string;
}
