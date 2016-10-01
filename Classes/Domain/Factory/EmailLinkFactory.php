<?php
namespace In2code\Email2powermail\Domain\Factory;

use In2code\Email2powermail\Domain\Model\Email;
use In2code\Email2powermail\Domain\Model\EmailLink;
use In2code\Email2powermail\Domain\Repository\EmailRepository;
use In2code\Email2powermail\Utility\DomDocumentUtility;
use In2code\Email2powermail\Utility\ObjectUtility;
use In2code\Email2powermail\Utility\StringUtility;

/**
 * Class EmailLinkFactory returns array with a bundle of EmailLink objects that keep all email-address-links of a
 * given content
 */
class EmailLinkFactory
{

    /**
     * Hold all email address-links from the current content
     *
     * @var EmailLink[]
     */
    protected $emailAddresses = [];

    /**
     * Hold all email addresses/names from the database
     *
     *  [
     *      "mail@mail.org" => "name"
     *  ]
     *
     * @var array
     */
    protected $emailAddressesDatabase = [];

    /**
     * @param $content
     * @return EmailLink[]
     */
    public function getEmailLinksFromContent($content)
    {
        $this->addEmailAndNamesToLocalStorage();
        $this->addEmailAddressLinksToLocalStorage($content);
        return $this->getEmailAddresses();
    }

    /**
     * @return void
     */
    protected function addEmailAndNamesToLocalStorage()
    {
        $emailRepository = ObjectUtility::getObjectManager()->get(EmailRepository::class);
        /** @var Email $email */
        foreach ($emailRepository->findAll() as $email) {
            $this->emailAddressesDatabase[$email->getEmail()] = $email->getName();
        }
    }

    /**
     * @param string $content
     * @return void
     */
    protected function addEmailAddressLinksToLocalStorage($content)
    {
        $domDocument = DomDocumentUtility::getDomDocument($content);
        foreach ($domDocument->getElementsByTagName('a') as $aElement) {
            /** @var \DomElement $aElement */
            if ($aElement->hasAttribute('href')) {
                $href = trim($aElement->getAttribute('href'));
                if (StringUtility::isMailLink($href)) {
                    $this->addEmailAddressLink($href, $aElement->textContent, DomDocumentUtility::outerHTML($aElement));
                }
            }
        }
    }

    /**
     * @param string $href "mailto:mail@mail.org"
     * @param string $text "click me"
     * @param string $tagString "<a href="mailto:mail@mail.org">click me</a>"
     * @return void
     */
    protected function addEmailAddressLink($href, $text, $tagString)
    {
        $emailLink = ObjectUtility::getObjectManager()->get(EmailLink::class, $href, $text, $tagString);
        if (array_key_exists($emailLink->getEmail(), $this->emailAddressesDatabase)) {
            $emailLink->setName($this->emailAddressesDatabase[$emailLink->getEmail()]);
            $emailLink->setChangeLink(true);
            $emailLink->setHrefnew('index.php?id=123');
        }
        $this->emailAddresses[] = $emailLink;
    }

    /**
     * @return EmailLink[]
     */
    protected function getEmailAddresses()
    {
        return $this->emailAddresses;
    }
}
