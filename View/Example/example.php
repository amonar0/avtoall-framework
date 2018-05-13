<?php

use AutoAlliance\Technology\Html\Div;
use AutoAlliance\View\Core\View;
use AutoAlliance\Controller\NewFolder\Example\ExampleController;
use AutoAlliance\Technology\Html\Tag;
use AutoAlliance\View\Example\ExampleView;

/* @var $view View */

?>
    <div onclick="<?= $view->clientApi('test') ?>" class="<?= $style['text'] ?>"><?= $a ?></div>

<?php
foreach ($labels as $txt) {
    echo new Div("label: $txt", 'some-text');
}

$url1 = $view->uriCreator()->uri(
    ExampleController::class,
    [ExampleController::TEST_PARAMETER => ['v', '1'],],
    ExampleView::TEST_FRAGMENT
);

echo new Tag('a', 'link', [], ['href' => (string)$url1]);
echo new Tag('a', 'link', [], ['href' => (string)$view->uriCreator()->uriFragment(ExampleView::TEST_FRAGMENT)]);
echo new Div('anchor', $style->subStyleMap('otherCss')['other-text'], [
    'id' => $view->uriCreator()->anchor(ExampleView::TEST_FRAGMENT),
]);