<?php

namespace AutoAlliance\Technology\FrameworkAdapter;

use AutoAlliance\Technology\Common\AnyClassFactory;
use AutoAlliance\Technology\FileSystem\File\Directory;
use AutoAlliance\Technology\FileSystem\File\PhpFile;
use BaseController;
/* @uses Yii */

use CWebModule;
/** @uses Yii */

use AutoAlliance\Controller\Core\ControllerFinder;
use AutoAlliance\Controller\Core\ControllerClass;
use Psr\Container\ContainerInterface;

final class FrontController extends BaseController
{
    /**
     * @var ContainerInterface
     */
    private $diContainer;
    /**
     * @var AnyClassFactory
     */
    private $factory;
    /**
     * @var ControllerFinder
     */
    private $controllerFinder;
    /**
     * @var AccessRulesCreator
     */
    private $accessRulesCreator;

    public function __construct(string $id, CWebModule $module = null)
    {
        parent::__construct($id, $module);
        global $diContainer;

        $this->diContainer = $diContainer;
        $this->factory = $this->diContainer->get(AnyClassFactory::class);
        $this->controllerFinder = $this->diContainer->get(ControllerFinder::class);

    }

    public function init() {
        parent::init();
        $this->accessRulesCreator = $this->diContainer->get(AccessRulesCreator::class);
    }

    public function filters(): array
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules(): array
    {
        $rules = $this->accessRulesCreator->create();

        return $this->replaceControllerClassesWithActionIdsInRules($rules);
    }

    public function createAction(/*string*/
        $actionId
    ) {
        $controllerClass = $this->controllerMap()[$actionId] ?? null;

        assert($controllerClass, $actionId);

        return $this->diContainer->get($controllerClass->getName());
    }

    public function run(/*string*/
        $actionId
    )//: void
    {
        global $newProjectErrorLevel;
        $oldLevel = error_reporting($newProjectErrorLevel);

        parent::run($actionId);

        error_reporting($oldLevel);
    }

    private function replaceControllerClassesWithActionIdsInRules(array $rules): array
    {
        return array_map(function (array $rule) {
            $rule['actions'] = array_map(function (string $controllerClass) {
                $class = $this->factory->create(ControllerClass::class, [$controllerClass]);

                return $class->id();
            }, $rule['actions']);

            return $rule;
        }, $rules);
    }

    /**
     * @return ControllerClass[]
     */
    private function controllersList(): array
    {
        return $this->controllerFinder->findAll();
    }

    private $controllersMap = [];

    private function controllerMap(): array
    {
        if (!$this->controllersMap) {
            foreach ($this->controllersList() as $class) {
                $this->controllersMap[$class->id()] = $class;
            }
        }

        return $this->controllersMap;
    }
}