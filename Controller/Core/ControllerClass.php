<?php
/**
 * Created by PhpStorm.
 * User: amonar
 * Date: 03.10.17
 * Time: 0:46
 */

namespace AutoAlliance\Controller\Core;

use AutoAlliance\Technology\Common\CastableTrait;

final class ControllerClass extends \ReflectionClass
{
    use CastableTrait;

    /**
     * @var string
     */
    private $controllersBaseNamespace;

    public function __construct($argument, string $controllersBaseNamespace)
    {
        parent::__construct($argument);
        assert($this->isSubclassOf(Controller::class));
        $this->controllersBaseNamespace = $controllersBaseNamespace;
    }

    public function relativePath(): string
    {
        $pattern = sprintf('/^%s/', preg_quote($this->controllersBaseNamespace . '\\'));
        $relativeClass = preg_replace($pattern, '', $this->getName());

        $path = preg_replace('/\\\\[a-zA-Z0-9]+Controller$/', '', $relativeClass);
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);

        return $path;
    }

    public function id(): string
    {
        $path = $this->relativePath();
        $id = str_replace(DIRECTORY_SEPARATOR, '', $path);

        return $id;
    }

    protected function constructorValue()
    {
        return $this->getName();
    }
}