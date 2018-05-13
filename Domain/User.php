<?php

namespace AutoAlliance\Domain;

final class User
{
    /**
     * @var Person[]
     */
    protected $recipients;

    /**
     * @var Person
     */
    protected $customer;
}