<?php

namespace AutoAlliance\Domain\Authentication;

use AutoAlliance\Technology\Common\ScalarValueObjectCompanionInterface;
use AutoAlliance\Technology\Common\SingletonTrait;

final class LoginCompanion implements ScalarValueObjectCompanionInterface
{
    use SingletonTrait;

    public static function instance(): self
    {
        return self::proceedInstance();
    }

    public function validate(/*string*/
        $string
    ): array {
        assert(is_string($string), $string);

        return [true, ''];
    }

    public function createFromScalar(/*string*/
        $loginString
    )/*:Login*/
    {
        return new Login($loginString);
    }
}