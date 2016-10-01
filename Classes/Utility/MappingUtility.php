<?php
namespace In2code\Email2powermail\Utility;

/**
 * Class MappingUtility
 */
class MappingUtility
{

    /**
     * @return array
     */
    public static function getMappingConfiguration($className)
    {
        $typoScriptExtbase = ObjectUtility::getTyposcriptFrontendController()->tmpl->setup['config.']['tx_extbase.'];
        if (!empty($typoScriptExtbase['persistence.']['classes.'][$className . '.']['mapping.'])) {
            return $typoScriptExtbase['persistence.']['classes.'][$className . '.']['mapping.'];
        }
        return [];
    }
}
