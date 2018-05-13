<?php

namespace AutoAlliance\View\Example;

use AutoAlliance\Technology\Http\Request\UriCreatorInterface;
use AutoAlliance\View\Core\ClientPackage\ViewPackageFactory;
use AutoAlliance\View\Core\ClientSettings\ClientSettings;
use AutoAlliance\View\Core\RenderStrategy\RenderStrategyInterface;
use AutoAlliance\View\Core\Style\StyleMapMapFactory;
use AutoAlliance\View\Core\View;

final class ExampleView extends View
{

    const TEST_FRAGMENT = TestFragment::class;

    /**
     * @var string[] $labels
     */
    protected $labels;

    /**
     * @var int $number
     */
    private $number;

    public function __construct(
        int $number,
        array $labels,
        UriCreatorInterface $uriCreator,
        ViewPackageFactory $clientPackageFactory,
        RenderStrategyInterface $renderStrategy,
        StyleMapMapFactory $styleMapMapFactory
    ) {
        parent::__construct($uriCreator, $clientPackageFactory, $renderStrategy, $styleMapMapFactory);
        $this->number = $number;
        $this->labels = $labels;
    }

    public function clientSettings(): ClientSettings
    {
        return new ClientSettings([
            'data' => 'test',
        ], [
            'someAjax' => new \AutoAlliance\Technology\Http\Request\Uri('http://google.ru'),
        ]);
    }

    protected function templateCustomDataMap(): array
    {
        return [
            'a' => $this->number,
        ];
    }

    protected function autoTemplateAttributeNames(): array
    {
        return ['labels'];
    }
}
