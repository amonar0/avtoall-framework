<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Interfaces;

use IUserIdentity; //@uses Yii

interface FrameworkLoginServiceInterface
{
    public function login_(IUserIdentity $userIdentity, int $durationLoggedIn = 0): bool;
}