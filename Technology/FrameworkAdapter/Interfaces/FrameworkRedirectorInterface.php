<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Interfaces;

interface FrameworkRedirectorInterface
{
    public function redirect(/*array|string*/ $frameworkUrl, bool $needToTerminate, int $statusCode = 302)/*: void*/;
}