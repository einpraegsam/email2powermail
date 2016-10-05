<?php
namespace In2code\Email2powermail\Slots;

use In2code\Email2powermail\Domain\Model\Email;
use In2code\Email2powermail\Domain\Repository\EmailRepository;
use In2code\Email2powermail\Utility\ConfigurationUtility;
use In2code\Email2powermail\Utility\FrontendUtility;
use In2code\Email2powermail\Utility\ObjectUtility;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Class ReceiverEmailService
 */
class ReceiverEmailService implements SingletonInterface {

    /**
     * @var null|Email
     */
    protected $email = null;

    /**
     * Decode constructor.
     */
    public function __construct()
    {
        if ($this->email === null && ConfigurationUtility::isExtensionTurnedOn()) {
            $emailRepository = ObjectUtility::getObjectManager()->get(EmailRepository::class);
            $this->email = $emailRepository->findByIdentifier(FrontendUtility::getIdentifier());
        }
    }

    /**
     * Manipulate receiver email address
     *
     * @param array $emailArray
     * @return void
     */
    public function setReceiverEmails(array &$emailArray) {
        if (ConfigurationUtility::isExtensionTurnedOn()) {
            $emailArray[0] = $this->email->getEmail();
        }
    }

    /**
     * Manipulate receiver name
     *
     * @param string $receiverName
     * @return void
     */
    public function getReceiverName(&$receiverName)
    {
        if (ConfigurationUtility::isExtensionTurnedOn()) {
            $receiverName = $this->email->getName();
        }
    }
}
