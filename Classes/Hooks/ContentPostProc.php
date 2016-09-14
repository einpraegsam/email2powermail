<?php
namespace In2code\Email2powermail\Domain\Model;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class ContentPostProc
 */
class ContentPostProc {

    /**
     * @param array $params
     * @param TypoScriptFrontendController $tsfe
     */
    public function manipulateOutput(array &$params, TypoScriptFrontendController $tsfe) {
        $params['pObj']->content = 'xxx';
    }
}
