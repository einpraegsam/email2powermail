<?php
namespace In2code\Email2powermail\Utility;

/**
 * Class StringUtility
 */
class ArrayUtility
{

    /**
     * Rename Array keys with a given mapping table
     *
     * @param array $array
     * @param string $prefix
     * @return array
     */
    public static function prefixArrayKeys(array $array, $prefix = 'email2powermail_')
    {
        foreach (array_keys($array) as $key) {
            $array[$prefix . $key] = $array[$key];
            unset($array[$key]);
        }
        return $array;
    }
}
