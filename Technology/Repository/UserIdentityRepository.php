<?php

namespace AutoAlliance\Technology\Repository;

use AutoAlliance\Domain\PhoneNumber;
use AutoAlliance\Domain\Person;
use User; //@uses db
//@todo реализация класса
//@todo в extends AR
final class UserIdentityRepository
{
    /**
     * @var
     */
    private $yiiRepository;

    public function __construct()
    {

    }

    public function byPhone(PhoneNumber $phone): self
    {
        return $this;
    }

    public function find(): Person
    {

    }
}