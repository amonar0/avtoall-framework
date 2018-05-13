<?php

namespace AutoAlliance\Domain\Authentication;

use AutoAlliance\Domain\PhoneNumber;
use AutoAlliance\Domain\PhoneNumberCompanion;
use AutoAlliance\Technology\Common\ScalarValueObjectCompanionInterface;
use AutoAlliance\Technology\Common\SingletonTrait;
use AutoAlliance\Technology\Email\Email;
use AutoAlliance\Technology\Email\EmailCompanion;

final class AnyLoginCompanion implements ScalarValueObjectCompanionInterface
{
    use SingletonTrait;

    public static function instance(): self
    {
        return self::proceedInstance();
    }

    public function validate($value): array
    {
        $isValid = EmailCompanion::instance()->validate($value)[0]
            || PhoneNumberCompanion::instance()->validate($value)[0]
            || LoginCompanion::instance()->validate($value)[0];

        $message = sprintf('Недопустимый логин "%s"', $value);

        return [$isValid, $isValid ? '' : $message];
    }

    public function createFromScalar(/*string*/
        $login
    )/*: LoginInterface*/
    {
        if (EmailCompanion::instance()->validate($login)[0]) {
            return new Email($login);
        } elseif (PhoneNumberCompanion::instance()->validate($login)[0]) {
            return new PhoneNumber($login);
        } elseif (LoginCompanion::instance()->validate($login)[0]) {
            return new Login($login);
        }

        assert(false,
            "Login '$login' does not fit to all objects of 'LoginInterface' type");
    }
}