<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Yii;

/** @uses Yii */
use CHttpException;

class HttpException extends CHttpException
{

    public function __construct(int $httpCode, string $message = '')
    {
        if (!$message) {
            $message = null;
        }

        parent::__construct($httpCode, $message, 0);
    }
}
