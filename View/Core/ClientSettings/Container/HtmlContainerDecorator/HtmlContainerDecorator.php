<?php

namespace AutoAlliance\View\Core\ClientSettings\Container\HtmlContainerDecorator;

use AutoAlliance\View\Core\ClientSettings\Container\ContainerInterface;
use AutoAlliance\View\Core\RenderStrategy\RenderStrategyInterface;
use AutoAlliance\View\Core\View;
use AutoAlliance\Technology\Html\Div;

final class HtmlContainerDecorator implements ContainerInterface, RenderStrategyInterface
{

    /**
     * @var RenderStrategyInterface $renderStrategy
     */
    private $renderStrategy;

    public function __construct(RenderStrategyInterface $renderStrategy)
    {
        $this->renderStrategy = $renderStrategy;
    }

    public function render(View $view): string
    {
        $container = new Div([], 'settings-container', [
            'data-server-data' => json_encode($view->clientSettings()),
        ]);

        return $container . $this->renderStrategy->render($view);
    }
}
