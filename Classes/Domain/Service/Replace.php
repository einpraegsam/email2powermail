<?php
namespace In2code\Email2powermail\Domain\Service;

use In2code\Email2powermail\Domain\Factory\EmailLinkFactory;
use In2code\Email2powermail\Domain\Factory\SimpleEmailLinkFactory;
use In2code\Email2powermail\Domain\Model\EmailLink;
use In2code\Email2powermail\Utility\ConfigurationUtility;
use In2code\Email2powermail\Utility\ObjectUtility;

/**
 * Class Replace
 */
class Replace {

    /**
     * @param string $content
     * @return string
     */
    public function replaceInContent($content) {
        if (ConfigurationUtility::isExtensionTurnedOn()) {
            if (ConfigurationUtility::isInSimpleMode()) {
                $emailLinks = ObjectUtility::getObjectManager()->get(SimpleEmailLinkFactory::class)
                    ->getEmailLinksFromContent($content);
            } else {
                $emailLinks = ObjectUtility::getObjectManager()->get(EmailLinkFactory::class)
                    ->getEmailLinksFromContent($content);
            }

            foreach ($emailLinks as $emailLink) {
                /** @var EmailLink $emailLink */
                if ($emailLink->isChangeLink()) {
                    $content = str_replace($emailLink->getTagString(), $emailLink->getTagStringNew(), $content);
                }
            }
        }
        return $content;
    }
}
