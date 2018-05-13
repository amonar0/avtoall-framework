<?php

namespace AutoAlliance\Technology\Http\Request;

use AutoAlliance\Technology\Helper\Lists;

final class Uri
{

    /**
     * @var string $uri
     */
    private $uri;

    public static function fromParts(array $parts)
    {
        $uri = http_build_url($parts);

        assert($uri !== false, sprintf('Error when building uri from parts: %s', Lists::toString($parts)));

        return self($uri);
    }

    public function __construct(string $uri)
    {
        assert(parse_url($uri) !== false, sprintf('Error when parsing uri: %s', $uri));

        $this->uri = $uri;
    }

    public function __toString(): string
    {
        return $this->uri;
    }
}
