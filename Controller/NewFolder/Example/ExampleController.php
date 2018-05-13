<?php

namespace AutoAlliance\Controller\NewFolder\Example;

use AutoAlliance\Controller\Core\Controller;
use AutoAlliance\View\Example\ExampleView;

final class ExampleController extends Controller
{

    //const PARAMETERS = [self::TEST_PARAMETER];
    const TEST_PARAMETER = TestParameter::class;

    public function present(): string
    {
        return $this->presenterFactory()->create(ExampleView::class, 123, ['all', 'that', 'labels'])->present();
    }
}
