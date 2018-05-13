<?php

namespace AutoAlliance\Technology\Helper;

final class Map
{

    public static function map(array $sourceMap, callable $callback): array
    {
        $result = [];
        foreach ($sourceMap as $key => $value) {
            $result[$key] = $callback($value);
        }

        return $result;
    }

    public static function cut(array $map, $key): array
    {
        assert(isset($map[$key]), 'Out of bounds. Key, array: %s, %s', $key, Lists::toString($map));

        $item = $map[$key];
        unset($map[$key]);

        return [$item, $map];
    }

    public static function fromList(array $list, callable $keyValueFactory): array
    {
        $map = [];

        foreach ($list as $item) {
            list ($key, $value) = $keyValueFactory($item);
            $map[$key] = $value;
        }

        return $map;
    }

    public static function mergeUnique(array ...$maps): array
    {
        $merged = [];

        foreach ($maps as $map) {
            foreach ($map as $key => $value) {
                assert(!isset($merged[$key]),
                    Output::sprintf('Key: %s, existing value: %s, new value: %s',
                        $key, $merged[$key] ?? null, $value));

                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}