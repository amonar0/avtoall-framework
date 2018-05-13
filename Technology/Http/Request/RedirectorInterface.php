<?php

namespace AutoAlliance\Technology\Http\Request;

interface RedirectorInterface
{
    public function redirect();
    public function redirectToFrameworkController();
}