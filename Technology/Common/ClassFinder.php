<?php

namespace AutoAlliance\Technology\Common;

use AutoAlliance\Technology\FileSystem\File\Directory;
use AutoAlliance\Technology\FileSystem\File\PhpFile;
use AutoAlliance\Technology\Php\CodeSentenceExtractor;

class ClassFinder
{
    /**
     * @var CodeSentenceExtractor
     */
    private $codeExtractor;

    public function __construct(CodeSentenceExtractor $codeExtractor)
    {
        $this->codeExtractor = $codeExtractor;
    }

    /**
     * @param Directory $baseDirectory
     * @param string $pathRegexp
     * @return ControllerClass[]
     */
    public function find(Directory $baseDirectory, string $pathRegexp): array
    {
        $files = $baseDirectory->findRecursively($pathRegexp);
        $files = PhpFile::castList(...$files);

        return array_map(function (PhpFile $file) {
            return $this->codeExtractor->fullClass($file->content());
        }, $files);
    }
}