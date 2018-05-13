<?php

namespace AutoAlliance\View\Core\RenderStrategy;

use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingFile;
use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;
use AutoAlliance\View\Core\View;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\ThemeInterface;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\ControllerInterface;
use AutoAlliance\Technology\FileSystem\File\File;

final class RenderPhpViewStrategy implements RenderStrategyInterface
{

    /**
     * @var ControllerInterface
     */
    private $controller;
    /**
     * @var ThemeInterface
     */
    private $theme;

    public function __construct(ControllerInterface $controller, ThemeInterface $theme)
    {
        $this->controller = $controller;
        $this->theme = $theme;
    }

    public function render(View $view): string
    {
        $template = $this->resolve($view);

        return $this->controller->renderOut($template, $view->templateDataMap());
    }

    private function resolve(View $view): File
    {
        $viewDirectory = ReflectionClassHelper::baseDirectory($view);

        $path = $viewDirectory->addPath($this->viewRelativePath($view));
        return File::cast($path);
    }

    private function viewRelativePath(View $view): MaybeExistingFile
    {
        $themeDirectory = $this->theme->isDefault()
            ? ''
            : $this->theme->getName() . DIRECTORY_SEPARATOR;

        $class = ReflectionClassHelper::onlyClassName($view);
        $file = preg_replace('/View$/', '', lcfirst($class)) . '.php';

        return (new MaybeExistingFile($themeDirectory))->addPath($file);
    }
}