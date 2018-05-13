<?php

namespace AutoAlliance\ClientPackage\Core\Factory;

use AutoAlliance\Technology\FileSystem\File\ClientFile;
use AutoAlliance\Technology\FileSystem\File\Directory;
use AutoAlliance\ClientPackage\Core\ClientPackage;

/**
 * @author amonar
 * @doc Что не нужно использовать вне мест, которые предполагается не тестировать
 */
class DirectoryClientPackageFactory
{

    public function create(Directory $directory, string $id): ClientPackage
    {
        $files = ClientFile::castList(...$directory->glob('*.js', '*.css'));

        assert($files, sprintf('Directory has not js or css files: %s', $directory->getPathname()));

        return new ClientPackage($id, $files);
    }
}