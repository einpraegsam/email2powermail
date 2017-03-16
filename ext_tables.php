<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

call_user_func(function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'email2powermail',
        'Configuration/TypoScript',
        'Main Template'
    );

    if (\In2code\Email2powermail\Utility\ConfigurationUtility::isInSimpleMode()) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
            mod.web_list.table.tx_email2powermail_domain_model_email.hideTable = 1
        ');
    }
});
