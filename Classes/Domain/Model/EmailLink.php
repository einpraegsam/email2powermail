<?php
namespace In2code\Email2powermail\Domain\Model;

use In2code\Email2powermail\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * Class EmailLink
 */
class EmailLink
{

    /**
     * Example: "mail@mail.org"
     *
     * @var string
     */
    protected $emailAddress = '';

    /**
     * Wrapped text - Example: "click here"
     *
     * @var string
     */
    protected $text = '';

    /**
     * Complete tag - Example: "<a href="mailto:mail@mail.org">click me</a>"
     *
     * @var string
     */
    protected $tagString = '';

    /**
     * Example: "mailto:mail@mail.org?subject=New%20Email"
     *
     * @var string
     */
    protected $href = '';

    /**
     * Email object for replacement
     *
     * @var Email
     */
    protected $email = null;

    /**
     * Example: "index.php?id=12&tx_email2powermail[id]=23"
     * 
     * @var string
     */
    protected $hrefNew = '';

    /**
     * Complete new tag - Example: "<a href="index.php?id=12&tx_email2powermail[id]=3">click me</a>"
     *
     * @var string
     */
    protected $tagStringNew = '';

    /**
     * @var bool
     */
    protected $changeLink = false;

    /**
     * @var bool
     */
    protected $changeText = false;

    /**
     * EmailLink constructor.
     *
     * @param string $href
     * @param string $text
     * @param string $tagString
     * @return EmailLink
     */
    public function __construct($href, $text, $tagString)
    {
        $components = parse_url($href);
        $this->setHref($href);
        $this->setEmailAddress($components['path']);
        $this->setText($text);
        $this->setTagString($tagString);
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     * @return EmailLink
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return EmailLink
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagString()
    {
        return $this->tagString;
    }

    /**
     * @param string $tagString
     * @return EmailLink
     */
    public function setTagString($tagString)
    {
        $this->tagString = $tagString;
        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     * @return EmailLink
     */
    public function setHref($href)
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Email $email
     * @return EmailLink
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getHrefNew()
    {
        return $this->hrefNew;
    }

    /**
     * @param string $hrefNew
     * @return EmailLink
     */
    public function setHrefNew($hrefNew)
    {
        $this->hrefNew = $hrefNew;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagStringNew()
    {
        return $this->tagStringNew;
    }

    /**
     * @param string $tagStringNew
     * @return EmailLink
     */
    public function setTagStringNew($tagStringNew)
    {
        $this->tagStringNew = $tagStringNew;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isChangeLink()
    {
        return $this->changeLink;
    }

    /**
     * @param boolean $changeLink
     * @return EmailLink
     */
    public function setChangeLink($changeLink)
    {
        $this->changeLink = $changeLink;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isChangeText()
    {
        return $this->changeText;
    }

    /**
     * @return EmailLink
     */
    public function setChangeText()
    {
        if ($this->isChangeLink()) {
            if (ConfigurationUtility::isEnforceChangeTextActivated()) {
                $this->changeText = true;
            } else {
                $this->changeText = GeneralUtility::validEmail($this->getText());
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return ObjectAccess::getGettableProperties($this);
    }
}
