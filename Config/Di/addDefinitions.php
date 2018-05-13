<?php

use DI\ContainerBuilder;
use AutoAlliance\Technology\Di\DefinitionInheritance;
use DI\Definition\Source\DefinitionArray;

function addDefinitions(ContainerBuilder $builder)
{
    $commonDefinitionsSource = require __DIR__ . '/definitions.php';
    $commonDefinitions = new DefinitionArray($commonDefinitionsSource);
    $builder->addDefinitions($commonDefinitions);
    $builder->addDefinitions(new DefinitionInheritance($commonDefinitions, $commonDefinitionsSource));
}