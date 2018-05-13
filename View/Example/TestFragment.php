<?php

namespace AutoAlliance\View\Example;

final class TestFragment extends \AutoAlliance\Technology\Http\Request\Fragment
{

    protected function viewClass(): string
    {
        return ExampleView::class;
    }
}
