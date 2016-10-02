<?php
namespace In2code\Email2powermail\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FrontendUtility
 */
class FrontendUtility
{

    /**
     * Try to get current identifier (&tx_email2powermail[id]=123)
     * @return int
     */
    public static function getIdentifier()
    {
        $pluginVariables = GeneralUtility::_GP('tx_email2powermail');
        return (int)$pluginVariables['id'];
    }
}
