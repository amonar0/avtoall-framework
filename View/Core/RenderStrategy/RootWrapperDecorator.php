<?php

namespace AutoAlliance\View\Core\RenderStrategy;

use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;
use AutoAlliance\Technology\Html\Div;
use AutoAlliance\View\Core\View;
use AutoAlliance\Technology\Helper\Debug;

final class RootWrapperDecorator implements RenderStrategyInterface
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
        $result = $this->renderStrategy->render($view);
        $attributes = [
            'id' => $this->createWrapperId($view),
        ];

        $debugText = '';
        if (Debug::enabled()) {
            $attributes['style'] = 'border: 1px solid red';
            $debugText = ReflectionClassHelper::onlyClassName($view);
        }

        return (string)new Div($result, 'view-wrapper', $attributes) . $debugText;
    }

    private function createWrapperId(View $view): string
    {
        return sprintf('%s-%s', ReflectionClassHelper::onlyClassName($view), time());
    }
}
