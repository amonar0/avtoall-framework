<?php

namespace AutoAlliance\Technology\Email;

use AutoAlliance\Technology\Common\ScalarValueObjectCompanionInterface;
use AutoAlliance\Technology\Common\SingletonTrait;

final class EmailCompanion implements ScalarValueObjectCompanionInterface
{
    use SingletonTrait;

    public static function instance(): self
    {
        return self::proceedInstance();
    }

    public function validate(/*string*/
        $string
    ): array {
        $isValid = (bool)filter_var($string, FILTER_VALIDATE_EMAIL);
        $message = $isValid ? '' : sprintf('"%s" не является адресом электронной почты', $string);

        return [$isValid, $message];
    }

    public function createFromScalar(/*string*/
        $emailString
    )/*:Email*/
    {
        return new Email($emailString);
    }
}