<?php

namespace AutoAlliance\Domain;

use AutoAlliance\Technology\FrameworkAdapter\Interfaces\FrameworkLoginServiceInterface;
use IUserIdentity; //@uses Yii

final class LoginService
{
    /**
     * @var FrameworkLoginServiceInterface
     */
    private $frameworkLoginService;

    public function __construct(FrameworkLoginServiceInterface $frameworkLoginService)
    {
        $this->frameworkLoginService = $frameworkLoginService;
    }

    public function login(IUserIdentity $userIdentity): bool
    {
        //@todo сделать через dateinterval
        //@todo починить авторизацию, сейчас не работает
        //$durationLoggedIn = new \DateInterval('P30D');
        $dur = 3600 * 24 * 30;
        return $this->frameworkLoginService->login($userIdentity, $dur);
    }
}