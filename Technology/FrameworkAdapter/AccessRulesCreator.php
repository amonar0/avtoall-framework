<?php

namespace AutoAlliance\Technology\FrameworkAdapter;

use AutoAlliance\Controller\User\Login\LoginController;
use AutoAlliance\Technology\Http\Request\Redirector;

final class AccessRulesCreator
{
    /**
     * @var Redirector
     */
    private $redirector;

    public function __construct(Redirector $redirector)
    {
        $this->redirector = $redirector;
    }

    public function create(): array
    {
        return [
            [
                'deny',
                'actions' => [LoginController::class],
                'users' => ['@'],
                'deniedCallback' => function() {
                    $this->redirector->redirectToFrameworkController(['site/index']);
                },
            ],
        ];
    }
}