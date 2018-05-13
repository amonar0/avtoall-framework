<?php

namespace AutoAlliance\Technology\Http\Exception;

use AutoAlliance\Technology\FrameworkAdapter\Yii\HttpException;

final class NotFoundHttpException extends HttpException
{
    public function __construct(string $message = '')
    {
        parent::__construct(404, $message);
    }
}
