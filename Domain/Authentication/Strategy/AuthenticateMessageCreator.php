<?php

namespace AutoAlliance\Domain\Authentication\Strategy;

use CUserIdentity;//@uses Yii

final class AuthenticateMessageCreator
{
    public function createMessage(
        /*comparable*/
        $errorCode,
        string $loginErrorMessage = 'Неверный пользователь',
        string $passwordErrorMessage = 'Неверный пароль'
    ): string {
        switch ($errorCode) {
            case CUserIdentity::ERROR_USERNAME_INVALID:
                $message = $loginErrorMessage;
                break;
            case CUserIdentity::ERROR_PASSWORD_INVALID:
                $message = $passwordErrorMessage;
                break;
            case CUserIdentity::ERROR_NONE:
                $message = '';
                break;
            default:
                assert(false, "Unknown errorCode: $errorCode");
                break;
        }

        return $message;
    }
}