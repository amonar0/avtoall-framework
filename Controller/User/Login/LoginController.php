<?php

namespace AutoAlliance\Controller\User\Login;

use AutoAlliance\Controller\Core\Controller;
use AutoAlliance\Domain\LoginService;
use AutoAlliance\Technology\Common\AnyClassFactory;
use AutoAlliance\Technology\Common\PresenterFactoryInterface;
use AutoAlliance\Technology\Http\Request\Redirector;
use AutoAlliance\Technology\YiiForm\LoginForm;
use AutoAlliance\View\Login\LoginViewFactory;
use CController;
use AutoAlliance\Technology\Http\Request\Uri;

final class LoginController extends Controller
{
    /**
     * @var LoginService
     */
    private $loginService;
    /**
     * @var LoginForm
     */
    private $loginForm;
    /**
     * @var Redirector
     */
    private $redirector;
    /**
     * @var Uri|null
     */
    private $uriFromLoginRequiringPage;
    /**
     * @var LoginViewFactory
     */
    private $viewFactory;

    public function __construct(
        LoginViewFactory $viewFactory,
        LoginService $loginService,
        LoginForm $loginForm,
        Redirector $redirector,
        PresenterFactoryInterface $presenterFactory,
        AnyClassFactory $anyFactory,
        CController $controller,
        Uri $uriFromLoginRequiringPage = null
    ) {
        parent::__construct($presenterFactory, $anyFactory, $controller);
        $this->loginService = $loginService;
        $this->loginForm = $loginForm;
        $this->redirector = $redirector;
        $this->uriFromLoginRequiringPage = $uriFromLoginRequiringPage;
        $this->viewFactory = $viewFactory;
    }

    public function present(): string
    {
        //@todo Сделать хорошую форму, завернув внутрь нее форму Yii: иммутабельную, без лишних методов и т.д.
        //@todo подумать, как лучше получать POST, и сделать
        $this->loginForm->ifValid($_POST['AutoAlliance_Technology_YiiForm_LoginForm'] ?? [],
            function (LoginForm $form) {
                list ($authenticated, $userIdentity) = $form->authenticate();

                if (!$authenticated) {
                    return;
                }

                $isLoginSuccessful = $this->loginService->login($userIdentity);

                assert($isLoginSuccessful);

                if ($this->uriFromLoginRequiringPage) {
                    $this->redirector->redirectToUri($this->uriFromLoginRequiringPage);
                } else {
                    $this->redirector->redirectToFrameworkController(['site/index']);
                }
            });

        //@todo сделать систему для лейаута
        $this->getController()->pageTitle = 'Авторизация на сайте';

        return $this->viewFactory->create($this->loginForm)->present();
    }
}