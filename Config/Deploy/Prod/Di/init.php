<?php

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ApcuCache;

require __DIR__ . '/addDefinitions.php';

$builder = new ContainerBuilder();
$builder->setDefinitionCache(new ApcuCache());
$builder->writeProxiesToFile(true, 'tmp/proxies');

addDefinitions($builder);
return $builder->build();