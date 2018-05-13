<?php

namespace AutoAlliance\View\Login;

use AutoAlliance\Technology\Common\AnyClassFactory;
use AutoAlliance\Technology\YiiForm\LoginForm;

final class LoginViewFactory
{
    /**
     * @var AnyClassFactory
     */
    private $factory;

    public function __construct(AnyClassFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(LoginForm $form): LoginView
    {
        return $this->factory->create(LoginView::class, [$form]);
    }
}