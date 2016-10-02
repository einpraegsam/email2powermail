<?php
namespace In2code\Email2powermail\Hooks;

use In2code\Email2powermail\Domain\Service\Replace;
use In2code\Email2powermail\Utility\ObjectUtility;

/**
 * Class ContentPostProc
 */
class ContentPostProc {

    /**
     * @param array $params
     * @return void
     */
    public function manipulateOutput(array &$params) {
        $replaceService = ObjectUtility::getObjectManager()->get(Replace::class);
        $params['pObj']->content = $replaceService->replaceInContent($params['pObj']->content);
    }
}
