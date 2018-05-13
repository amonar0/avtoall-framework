<?php

namespace AutoAlliance\View\Core\SelectClientFilesStrategy;

use AutoAlliance\Technology\FrameworkAdapter\Interfaces\ThemeInterface;
use AutoAlliance\Technology\FileSystem\File\ClientFile;
use AutoAlliance\Technology\FileSystem\SelectFilesInDirectoryStragegyInterface;
use AutoAlliance\Technology\FileSystem\File\MaybeExisting\MaybeExistingDirectoryInterface;

final class SelectClientFilesByThemeStrategy implements SelectFilesInDirectoryStragegyInterface
{

    /**
     * @var ThemeInterface $theme
     */
    private $theme;

    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    public function select(MaybeExistingDirectoryInterface $baseDirectory): array
    {
        $themeDir = $this->theme->isDefault() ? '' : $this->theme->getName();
        $themeDirectory = $baseDirectory->addDirectory($themeDir);
        $commonDirectory = $baseDirectory->addDirectory('common');
        $patterns = ['*.js', '*.processed.css'];

        $files = array_merge($commonDirectory->glob(...$patterns), $themeDirectory->glob(...$patterns));

        return ClientFile::castList(...$files);
    }
}