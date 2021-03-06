<?php
namespace In2code\Email2powermail\UserFuncs;

use In2code\Email2powermail\Domain\Model\Email;
use In2code\Email2powermail\Domain\Repository\EmailRepository;
use In2code\Email2powermail\Utility\FrontendUtility;
use In2code\Email2powermail\Utility\ObjectUtility;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Class Decode could be included via TypoScript to decode email or name from given identifier
 */
class Decode implements SingletonInterface
{

    /**
     * @var null|Email
     */
    protected $email = null;

    /**
     * Decode constructor.
     */
    public function __construct()
    {
        if ($this->email === null) {
            $emailRepository = ObjectUtility::getObjectManager()->get(EmailRepository::class);
            $this->email = $emailRepository->findByIdentifier(FrontendUtility::getIdentifier());
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ($this->email !== null) {
            return $this->email->getName();
        }
        return 'Error, no name found!';
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        if ($this->email !== null) {
            return $this->email->getEmail();
        }
        return 'Error, no email found!';
    }
}
