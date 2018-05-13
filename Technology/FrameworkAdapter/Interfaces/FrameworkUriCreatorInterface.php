<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Interfaces;

use AutoAlliance\Technology\Http\Request\Uri;

interface FrameworkUriCreatorInterface
{

    public function createUri(string $route, array $queryParameters = []): Uri;
}
