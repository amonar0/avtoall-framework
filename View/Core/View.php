<?php

namespace AutoAlliance\View\Core;

use AutoAlliance\View\Core\ClientPackage\ViewPackageFactoryInterface;
use AutoAlliance\View\Core\ClientSettings\ClientSettings;
use AutoAlliance\View\Core\RenderStrategy\RenderStrategyInterface;
use AutoAlliance\Technology\Html\HtmlPresenterInterface;
use AutoAlliance\Technology\Http\Request\UriCreatorInterface;
use AutoAlliance\View\Core\ClientPackage\ViewPackageFactory;
use AutoAlliance\View\Core\Style\StyleMapMapFactory;
use AutoAlliance\View\Core\Style\StyleMapsTree;
use AutoAlliance\Technology\Helper\Map;

abstract class View implements HtmlPresenterInterface
{
    /**
     * @var UriCreatorInterface
     */
    private $uriCreator;
    /**
     * @var ViewPackageFactory
     */
    private $clientPackageFactory;
    /**
     * @var RenderStrategyInterface
     */
    private $renderStrategy;
    /**
     * @var StyleMapMapFactory
     */
    private $styleMapMapFactory;

    public function __construct(
        UriCreatorInterface $uriCreator,
        ViewPackageFactoryInterface $clientPackageFactory,
        RenderStrategyInterface $renderStrategy,
        StyleMapMapFactory $styleMapMapFactory
    ) {

        $this->uriCreator = $uriCreator;
        $this->clientPackageFactory = $clientPackageFactory;
        $this->renderStrategy = $renderStrategy;
        $this->styleMapMapFactory = $styleMapMapFactory;
    }

    public function clientSettings(): ClientSettings
    {
        return ClientSettings::emptyInstance();
    }

    //@todo подумать, как убрать инверсию. сейчас рендерится, получая внутренние данные Вида через публичные методы,
    //а нужно наоборот. Проблема в том, что сходу непонятно, как поступить с передачей клиентских данных
    //при таком рефакторинге.

    //@todo пройтись по проекту на предмет таких же выворачиваний объектов наружу, как описано выше.
    final public function present(): string
    {
        return $this->renderStrategy->render($this);
    }

    final public function clientApi(string $methodCall): string
    {
        return $this->clientPackageFactory->clientApi($methodCall) . '(this)';
    }

    final public function uriCreator(): UriCreatorInterface
    {
        return $this->uriCreator;
    }

    final public function templateDataMap(): array
    {
        return Map::mergeUnique(
            $this->templateCustomDataMap(),
            $this->templateAutoAttributeMap(),
            $this->serviceDataMap());
    }

    protected function templateCustomDataMap(): array
    {
        return [];
    }

    protected function autoTemplateAttributeNames(): array
    {
        return [];
    }

    private function serviceDataMap(): array
    {
        return [
            'view' => $this,
            'style' => $this->arrangeStyleMaps(),
        ];
    }

    private function arrangeStyleMaps(): StyleMapsTree
    {
        $package = $this->clientPackageFactory;

        $styleMapMap = $this->styleMapMapFactory->create($package);
        $defaultStyleMap = $styleMapMap[$package->id()] ?? null;

        return new StyleMapsTree($styleMapMap, $defaultStyleMap);
    }

    private function templateAutoAttributeMap(): array
    {
        return Map::fromList($this->autoTemplateAttributeNames(), function ($attributeName) {
            return [$attributeName, $this->$attributeName];
        });
    }
}