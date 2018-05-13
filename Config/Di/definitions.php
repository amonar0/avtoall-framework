<?php

use AutoAlliance\Controller\Core\ControllerClass;
use AutoAlliance\Controller\User\Login\LoginController;
use AutoAlliance\Domain\Authentication\Strategy\AuthenticateByLoginPasswordStrategyFactory;
use AutoAlliance\Technology\Common\ClassFinder;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\FrameworkLoginServiceInterface;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\FrameworkRedirectorInterface;
use AutoAlliance\Technology\Helper\Map;
use AutoAlliance\Technology\Php\CodeSentenceExtractor;
use AutoAlliance\View\Core\ViewFinder;
use Yii as Yii;
/** @uses Yii */

use AutoAlliance\Technology\FrameworkAdapter\Route\RouteFactory;
use AutoAlliance\Controller\Core\ControllerFinder;
use function DI\object;
use function DI\get;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\ThemeInterface;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\ControllerInterface;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\ClientScriptManagerInterface;
use AutoAlliance\Technology\FrameworkAdapter\Interfaces\FrameworkUriCreatorInterface;
use AutoAlliance\Technology\Http\Request\UriCreatorInterface;
use AutoAlliance\Technology\Http\Request\RequestManager;
use AutoAlliance\Technology\Common\PresenterFactoryInterface;
use AutoAlliance\View\Core\ViewFactory;
use AutoAlliance\View\Core\View;
use AutoAlliance\View\Core\SelectClientFilesStrategy\SelectClientFilesByThemeStrategy;
use AutoAlliance\View\Core\ClientPackage\ViewPackageFactory;
use AutoAlliance\View\Core\ClientSettings\Container\ContainerInterface as SettingsContainerInterface;
use AutoAlliance\View\Core\ClientSettings\Container\HtmlContainerDecorator\HtmlContainerDecorator;
use AutoAlliance\View\Core\RenderStrategy\RootWrapperDecorator;
use AutoAlliance\View\Core\RenderStrategy\RenderPhpViewStrategy;
use AutoAlliance\ClientPackage\Core\ClientPackageFinder;
use AutoAlliance\Technology\FileSystem\File\Directory;
use AutoAlliance\Technology\YiiForm\LoginForm;
use AutoAlliance\Technology\Http\Request\Uri;

$viewsPath = createDir('AutoAlliance.View');

$definitions = array_merge(viewClientPackageDefinitions($viewsPath), [
    // Настройки
    'controllersBaseNamespace' => 'AutoAlliance\Controller',
    'path.clientPackages' => createDir('AutoAlliance.ClientPackage'),
    'path.views' => $viewsPath,
    'path.controllers' => createDir('AutoAlliance.Controller'),
    'path.config' => createDir('AutoAlliance.Config'),

    // Бизнес-логика
    LoginForm::class => object()->constructorParameter('authenticateStrategy',
        get(AuthenticateByLoginPasswordStrategyFactory::class)),

    // HMVC
    'uriFromLoginRequiringPage' => function(CWebApplication $app) {
        $returnUrl = $app->getUser()->getReturnUrl();;
        return $returnUrl ? new Uri($returnUrl) : null;
    },
    LoginController::class => object()
        ->constructorParameter('uriFromLoginRequiringPage', get('uriFromLoginRequiringPage')),

    PresenterFactoryInterface::class => get(ViewFactory::class),
    View::class => object()
        ->constructorParameter('renderStrategy',
            object(RootWrapperDecorator::class)
                ->constructorParameter('renderStrategy',
                    get(HtmlContainerDecorator::class))),
    SettingsContainerInterface::class => get(HtmlContainerDecorator::class),
    HtmlContainerDecorator::class => object()
        ->constructorParameter('renderStrategy',
            get(RenderPhpViewStrategy::class)),
    ViewPackageFactory::class => object()
        ->constructorParameter('selectFilesStrategy',
            get(SelectClientFilesByThemeStrategy::class)),

    //HTTP
    UriCreatorInterface::class => get(RequestManager::class),

    // Другое
    ClientPackageFinder::class => object()
        ->constructorParameter('clientPackagesBasePath',
            get('path.clientPackages'))
        ->constructorParameter('viewsBasePath', get('path.views')),
    ControllerFinder::class => object()
        ->constructorParameter('controllersBasePath', get('path.controllers')),
    RouteFactory::class => object()
        ->constructorParameter('uriDelimiter', '/')
        ->constructorParameter('frontControllerId', 'front'),
    ControllerClass::class => object()
        ->constructorParameter('controllersBaseNamespace',
            get('controllersBaseNamespace')),

    // Компоненты Yii
    CWebApplication::class => function () {
        return Yii::app();
    },
    CController::class => function (CWebApplication $app) {
        return $app->getController();
    },
    ControllerInterface::class => get(CController::class),
    ClientScriptManagerInterface::class => function (CWebApplication $app) {
        return $app->getClientScript();
    },
    ThemeInterface::class => function (CWebApplication $app): ThemeInterface {
        return $app->getTheme() ?? $app->getThemeManager()->getTheme('');
    },
    FrameworkUriCreatorInterface::class => function (CWebApplication $app):
    FrameworkUriCreatorInterface {
        return $app->getUrlManager();
    },
    FrameworkRedirectorInterface::class => get(CController::class),
    FrameworkLoginServiceInterface::class => function (CWebApplication $app) {
        return $app->getUser();
    },
]);
return $definitions;

function viewClientPackageDefinitions(Directory $viewsPath)
{
    $notMatterDirectory = new Directory(__DIR__);
    $classFinder = new ClassFinder(new CodeSentenceExtractor());
    $clientPackageFinder = new ClientPackageFinder(
        $notMatterDirectory,
        $notMatterDirectory,
        $classFinder
    );
    $viewFinder = new ViewFinder($viewsPath, $classFinder, $clientPackageFinder);

    return Map::fromList($viewFinder->findAll(), function (\ReflectionClass $viewClass) use ($viewFinder) {
        $clientPackageFactoryClass = $viewFinder->findClientPackage($viewClass);
        $definition = object()
            ->constructorParameter('clientPackageFactory',
                get($clientPackageFactoryClass->getName()));

        return [$viewClass->getName(), $definition];
    });
}

function createDir(string $alias)
{
    return new Directory(Yii::getPathOfAlias($alias));
}