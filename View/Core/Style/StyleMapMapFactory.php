<?php

namespace AutoAlliance\View\Core\Style;

use AutoAlliance\Technology\FileSystem\File\JsonFile;
use AutoAlliance\Technology\Helper\Map;
use AutoAlliance\Technology\Php\Reflection\ReflectionClassHelper;
    use AutoAlliance\View\Core\ClientPackage\ViewPackageFactoryInterface;

//@todo вероятно, должен быть у viewpackagefactory, а не у view
final class StyleMapMapFactory
{
    public function create(ViewPackageFactoryInterface $clientPackageFactory): array
    {
        $class = new \ReflectionClass($clientPackageFactory);
        $packageDirectory = ReflectionClassHelper::baseDirectory($class);

        $styleFiles = JsonFile::castList(...$packageDirectory->findRecursively('/.+\.css\.json$/'));

        return Map::fromList($styleFiles, function (JsonFile $file) {
            $id = $file->basenameWithoutAllExtensions();

            return [$id, new StyleMap($file->data())];
        });
    }
}