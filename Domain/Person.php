<?php

namespace AutoAlliance\Domain;

use AutoAlliance\Domain\FullName;
use AutoAlliance\Technology\Email\Email;
use AutoAlliance\Domain\PhoneNumber;

final class Person
{
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $patronymic;

    /**
     * @var Email
     */
    protected $email;

    /**
     * @var PhoneNumber
     */
    protected $phone;

    /**
     * @var PassportNumber
     */
    protected $passport;
}