<?php

namespace AutoAlliance\Technology\FileSystem\File;

final class JsonFile extends File
{
    /**
     * @var mixed
     */
    private $data;

    public function __construct(string $existingJsonFile)
    {
        parent::__construct($existingJsonFile);

        $this->data = json_decode($this->content(), true);

        assert(!json_last_error(), json_last_error_msg());
    }

    public function data()
    {
        return $this->data;
    }
}