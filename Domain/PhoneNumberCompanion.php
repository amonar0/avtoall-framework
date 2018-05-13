<?php

namespace AutoAlliance\Domain;

use AutoAlliance\Technology\Common\ScalarValueObjectCompanionInterface;
use AutoAlliance\Technology\Common\SingletonTrait;

final class PhoneNumberCompanion implements ScalarValueObjectCompanionInterface
{
    use SingletonTrait;

    public static function instance(): self
    {
        return self::proceedInstance();
    }

    public function validate(/*string|int*/
        $value
    ): array {
        assert(is_string($value) || is_int($value), $value);

        $isValid = is_numeric($value) && (int)$value == $value && (int)$value > 0;
        $message = $isValid ? '' : sprintf('"%s" не является телефонным номером', $value);

        return [$isValid, $message];
    }

    public function createFromScalar(/*int*/
        $phone
    )/*:PhoneNumber*/
    {
        return new PhoneNumber($phone);
    }
}