<?php

namespace AutoAlliance\View\Login;

use AutoAlliance\Technology\Http\Request\UriCreatorInterface;
use AutoAlliance\Technology\YiiForm\LoginForm;
use AutoAlliance\View\Core\ClientPackage\ViewPackageFactoryInterface;
use AutoAlliance\View\Core\RenderStrategy\RenderStrategyInterface;
use AutoAlliance\View\Core\Style\StyleMapMapFactory;
use AutoAlliance\View\Core\View;

final class LoginView extends View
{
    /**
     * @var LoginForm
     */
    protected $form;

    public function __construct(
        LoginForm $form,
        UriCreatorInterface $uriCreator,
        ViewPackageFactoryInterface $clientPackageFactory,
        RenderStrategyInterface $renderStrategy,
        StyleMapMapFactory $styleMapMapFactory
    ) {
        parent::__construct($uriCreator, $clientPackageFactory, $renderStrategy, $styleMapMapFactory);
        $this->form = $form;
    }

    protected function autoTemplateAttributeNames(): array
    {
        return ['form'];
    }
}