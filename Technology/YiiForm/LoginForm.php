<?php

namespace AutoAlliance\Technology\YiiForm;

use AutoAlliance\Domain\Authentication\AnyLoginCompanion;
use AutoAlliance\Domain\Authentication\LoginInterface;
use AutoAlliance\Domain\Authentication\Password;
use AutoAlliance\Domain\Authentication\PasswordCompanion;
use AutoAlliance\Domain\Authentication\Strategy\AuthenticateByLoginPasswordStrategyInterface;
use AutoAlliance\Technology\YiiForm\Core\BaseForm;

final class LoginForm extends BaseForm
{
    //@todo переделать на login, как сделаю верстку
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var bool @todo check is it true or it is int
     */
    public $thirdComputer;
    /**
     * @var AuthenticateByLoginPasswordStrategyInterface
     */
    private $authenticateStrategy;

    public function __construct(
        AuthenticateByLoginPasswordStrategyInterface $authenticateStrategy,
        string $scenario = ''
    ) {
        parent::__construct($scenario);
        $this->authenticateStrategy = $authenticateStrategy;
    }

    public function rules(): array
    {
        return [
            ['username, password', 'required'],
            ['thirdComputer', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'E-mail, телефон или логин',
            'password' => 'Пароль',
            'thirdComputer' => 'Чужой компьютер?',
        ];
    }

    protected function attributeValueObjectMap(): array
    {
        return [
            'username' => AnyLoginCompanion::instance(),
            'password' => PasswordCompanion::instance(),
        ];
    }

    public function authenticate(): array //[bool $authenticated, IUserIdentity $userIdentity]
    {
        list ($authenticated, $message, $userIdentity) = $this->authenticateStrategy->authenticate(
            $this->attribute('username'),
            $this->attribute('password')
        );

        if (!$authenticated) {
            $this->addError('password', $message);
        }

        return [$authenticated, $userIdentity];
    }

    public function login()
    {
        $duration = $this->thirdComputer ? 0 : 3600 * 24 * 30; // 30 days

        return Yii::app()->getUser()->login($this->identity, $duration);
    }
}