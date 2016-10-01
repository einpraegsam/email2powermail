<?php
namespace In2code\Email2powermail\Domain\Service;

use In2code\Email2powermail\Domain\Factory\EmailLinkFactory;
use In2code\Email2powermail\Domain\Model\EmailLink;
use In2code\Email2powermail\Utility\ConfigurationUtility;
use In2code\Email2powermail\Utility\ObjectUtility;

/**
 * Class Replace
 */
class Replace
{

    /**
     * Hold all email address-links of the current content
     *
     * @var EmailLink[]
     */
    protected $emailAddresses = [];

    /**
     * @param string $content
     * @return string
     */
    public function replaceInContent($content)
    {
        if (ConfigurationUtility::isExtensionTurnedOn()) {
            $this->emailAddresses = ObjectUtility::getObjectManager()->get(EmailLinkFactory::class)
                ->getEmailLinksFromContent($content);
        }
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->emailAddresses, 'in2code: ' . __CLASS__ . ':' . __LINE__);
        return $content;
    }
}
