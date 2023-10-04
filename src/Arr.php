<?php

namespace Spatie\DataTransferObject;

use ArrayAccess;

/**
 *
 */
class Arr
{
    /**
     * @param $array
     * @param $keys
     * @return array
     */
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * @param $array
     * @param $keys
     * @return array
     */
    public static function except($array, $keys)
    {
        return static::forget($array, $keys);
    }

    /**
     * @param $array
     * @param $keys
     * @return array
     */
    public static function forget($array, $keys)
    {
        $keys = (array) $keys;

        if (count($keys) === 0) {
            return $array;
        }

        foreach ($keys as $key) {
            // If the exact key exists in the top-level, remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);

                continue;
            }

            $parts = explode('.', $key);

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }

        return $array;
    }

    /**
     * @param $array
     * @param $key
     * @return bool
     */
    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }
}
