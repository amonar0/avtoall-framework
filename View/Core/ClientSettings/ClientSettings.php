<?php

namespace AutoAlliance\View\Core\ClientSettings;

use AutoAlliance\Technology\Common\JsonSerializableTrait;
use AutoAlliance\Technology\Common\SingletonTrait;
use AutoAlliance\Technology\Helper\Map;
use AutoAlliance\Technology\Http\Request\Uri;

/**
 * @author amonar
 */
final class ClientSettings implements \JsonSerializable
{
    use JsonSerializableTrait, SingletonTrait;
    /**
     * @var mixed[] $commonDataMap
     */
    private $commonDataMap;
    /**
     * @var Uri[] $uriMap
     */
    private $uriMap;

    public static function emptyInstance(): self
    {
        return self::proceedInstance([]);
    }

    public function __construct(array $commonDataMap, array $uriMap = [])
    {
        $this->commonDataMap = $commonDataMap;
        $this->uriMap = $uriMap;
    }

    public function addUri(string $id, Uri $uri): self
    {
        if (isset($this->uriMap[$id])) {
            throw new \OverflowException(sprintf('%s: %s', $id, $uri));
        }

        $uriMap = array_merge($this->uriMap, [$id => $uri]);

        return new self($this->commonDataMap, $uriMap);
    }

    public function addCommonData(string $id, $data): self
    {
        if (isset($this->commonDataMap[$id])) {
            throw new \OverflowException(sprintf('%s: %s', $id, (string)$data));
        }

        $commonDataMap[$id] = array_merge($this->commonDataMap, [$id => $data]);

        return new self($commonDataMap, $this->uriMap);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $data = Map::fromList(['commonDataMap', 'uriMap'], function ($attribute) {
            return [$attribute, $this->$attribute];
        });

        return $this->proceedJsonSerializable($data);
    }
}
