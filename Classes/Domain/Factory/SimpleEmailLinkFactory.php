<?php
namespace In2code\Email2powermail\Domain\Factory;

use In2code\Email2powermail\Domain\Factory\EmailLinkFactory;
use In2code\Email2powermail\Domain\Model\Email;
use In2code\Email2powermail\Domain\Model\EmailLink;
use In2code\Email2powermail\Domain\Repository\EmailRepository;
use In2code\Email2powermail\Utility\ConfigurationUtility;
use In2code\Email2powermail\Utility\ObjectUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 *  Simply add every mail address to cache and keep original link attributes
 */
class SimpleEmailLinkFactory extends EmailLinkFactory {

    /**
     * @var \In2code\Email2powermail\Domain\Repository\EmailRepository
     */
    protected $emailRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    function __construct() {
        $this->emailRepository = ObjectUtility::getObjectManager()->get(EmailRepository::class);
        $this->persistenceManager = ObjectUtility::getObjectManager()->get(PersistenceManager::class);
    }

    /**
     * @param string $href "mailto:mail@mail.org"
     * @param string $text content of link
     * @param string $tagString original link tag
     * @return void
     */
    protected function addEmailAddressLink($href, $text, $tagString) {
        $emailLink = ObjectUtility::getObjectManager()->get(EmailLink::class, $href, $text, $tagString);
        if (!array_key_exists($emailLink->getEmailAddress(), $this->emailAddressesDatabase)) {
            $newEmail = new Email();
            $newEmail->setEmail($emailLink->getEmailAddress());
            $this->emailRepository->add($newEmail);
            $this->persistenceManager->persistAll();
            $identifier = $this->persistenceManager->getIdentifierByObject($newEmail);
            $newEmail->setIdentifier($identifier);
            $this->emailAddressesDatabase[$emailLink->getEmailAddress()] = $newEmail;
        }

        $email = $this->emailAddressesDatabase[$emailLink->getEmailAddress()];
        $emailLink->setEmail($email);
        $emailLink->setChangeLink(true);
        $emailLink->setChangeText();
        $emailLink->setHrefNew($this->getPowermailLink($email));
        $emailLink->setTagStringNew($this->getTagStringNew($emailLink));
        $this->emailAddresses[] = $emailLink;
    }

    /**
     * @param EmailLink $emailLink
     * @return string
     */
    protected function getTagStringNew(EmailLink $emailLink) {
        $contentObject = ObjectUtility::getContentObject();
        $contentObject->start($emailLink->getEmail()->toArray() + $emailLink->toArray());
        $configuration = ConfigurationUtility::getExtensionConfiguration();
        $configuration['parseLink.']['typolink.']['returnLast'] = 'url';
        $url = $contentObject->cObjGetSingle($configuration['parseLink'], $configuration['parseLink.']);
        $tagStringNew = str_replace($emailLink->getHref(), $url, $emailLink->getTagString());
        return $tagStringNew;
    }
}

?>