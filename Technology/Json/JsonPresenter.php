<?php

namespace AutoAlliance\Technology\Json;

use AutoAlliance\Technology\Common\PresenterInterface;

final class JsonPresenter implements PresenterInterface
{

    /**
     * @var array $data ;
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function present(): string
    {
        return json_encode($this->data);
    }
}
