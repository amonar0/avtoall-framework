<?php

use DI\ContainerBuilder;

require __DIR__ . '/addDefinitions.php';

$builder = new ContainerBuilder();
addDefinitions($builder);
return $builder->build();