<?php

namespace AutoAlliance\Technology\Http\Exception;

use AutoAlliance\Technology\FrameworkAdapter\Yii\HttpException;

final class UnprocessableEntityHttpException extends HttpException
{

    public function __construct(string $message = '')
    {
        parent::__construct(422, $message);
    }
}
