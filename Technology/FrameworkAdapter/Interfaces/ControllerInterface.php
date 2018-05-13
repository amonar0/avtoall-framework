<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Interfaces;

use AutoAlliance\Technology\FileSystem\File\File;

/**
 * @author amonar
 * @see BaseController
 */
interface ControllerInterface
{

    public function renderOut(File $view, array $data): string;
}
