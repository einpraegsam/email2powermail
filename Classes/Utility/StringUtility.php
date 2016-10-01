<?php
namespace In2code\Email2powermail\Utility;

/**
 * Class StringUtility
 */
class StringUtility
{

    /**
     * @param string $href
     * @return bool
     */
    public static function isMailLink($href)
    {
        return strtolower(substr($href, 0, 7)) === 'mailto:';
    }
}
