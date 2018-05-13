<?php

namespace AutoAlliance\Controller\NewFolder\Example;

final class TestParameter extends \AutoAlliance\Technology\Http\Request\QueryParameter\ListParameter
{

    protected function controllerClass(): string
    {
        return ExampleController::class;
    }

    public function method(): \AutoAlliance\Technology\Http\Request\QueryMethod\QueryMethodInterface
    {
        return \AutoAlliance\Technology\Http\Request\QueryMethod\Get::instance();
    }

    public function optional(): bool
    {
        return true;
    }
}
