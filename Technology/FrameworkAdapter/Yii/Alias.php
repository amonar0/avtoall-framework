<?php

namespace AutoAlliance\Technology\FrameworkAdapter\Yii;

use AutoAlliance\Technology\FileSystem\File\File;
use AutoAlliance\Technology\FileSystem\File\Directory;
/** @uses Yii */

use Yii;

final class Alias
{

    /**
     * @var string $alias
     */
    private $alias;

    public function __construct(File $file = null)
    {
        $this->alias = $this->createAlias($file);
    }

    public function __toString(): string
    {
        return $this->alias;
    }

    private function createAlias(File $file): string
    {
        $docRoot = $this->docRoot();
        $path = $file->relativePath($docRoot);

        $alias = sprintf('webroot.%s', $path->getPathname());
        $alias = str_replace('.php', '', $alias);
        $alias = str_replace(DIRECTORY_SEPARATOR, '.', $alias);

        return $alias;
    }

    private function docRoot(): Directory
    {
        static $docRoot = null;
        if (!$docRoot) {
            $docRoot = new Directory(Yii::getPathOfAlias('webroot'));
        }

        return $docRoot;
    }
}
