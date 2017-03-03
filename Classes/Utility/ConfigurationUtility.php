<?php
namespace In2code\Email2powermail\Utility;

/**
 * Class ConfigurationUtility
 */
class ConfigurationUtility
{

    /**
     * @return bool
     */
    public static function isExtensionTurnedOn()
    {
        $configuration = self::getExtensionConfiguration();
        if (!empty($configuration['_enable'])) {
            $contentObject = ObjectUtility::getContentObject();
            return $contentObject->cObjGetSingle($configuration['_enable'], $configuration['_enable.']);
        }
        return false;
    }

    /**
     * @return int
     */
    public static function getPowermailPid()
    {
        $configuration = self::getExtensionConfiguration();
        if (!empty($configuration['powermailPid'])) {
            $contentObject = ObjectUtility::getContentObject();
            return $contentObject->cObjGetSingle($configuration['powermailPid'], $configuration['powermailPid.']);
        }
        return 1;
    }

    /**
     * @return bool
     */
    public static function isEnforceChangeTextActivated()
    {
        $configuration = self::getExtensionConfiguration();
        return !empty($configuration['enforceChangeText']);
    }

    /**
     * @return array
     */
    public static function getExtensionConfiguration()
    {
        $configuration = [];
        $tsfe = ObjectUtility::getTyposcriptFrontendController();
        if (!empty($tsfe->tmpl->setup['plugin.']['tx_email2powermail.']['settings.'])) {
            $configuration = $tsfe->tmpl->setup['plugin.']['tx_email2powermail.']['settings.'];
        }
        return $configuration;
    }


    /**
     * @return bool
     */
    public static function isLazyModeTurnedOn()
    {
        $configuration = self::getExtensionConfiguration();
        if (!empty($configuration['_enableLazyMode'])) {
            $contentObject = ObjectUtility::getContentObject();
            return (bool)$contentObject->cObjGetSingle($configuration['_enableLazyMode'], $configuration['_enableLazyMode.']);
        }
        return false;
    }
}
