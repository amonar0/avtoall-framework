<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Interfaces;

use IAction;
/** @uses Yii */

use CController;

interface RealActionInterface extends IAction
{

    public function getId(): string;

    public function getController(): CController;

    public function runWithParams(array $params): bool;
}
