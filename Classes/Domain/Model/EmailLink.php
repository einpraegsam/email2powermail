<?php
namespace In2code\Email2powermail\Domain\Model;

use In2code\Email2powermail\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
    protected $email = '';

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
     * Name for replacement in frontend
     *
     * @var string
     */
    protected $name = '';

    /**
     * Example: "index.php?id=12&tx_email2powermail[id]=23"
     * 
     * @var string
     */
    protected $hrefnew = '';

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
        $this->setEmail($components['path']);
        $this->setText($text);
        $this->setTagString($tagString);
        $this->setChangeText();
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EmailLink
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getHrefnew()
    {
        return $this->hrefnew;
    }

    /**
     * @param string $hrefnew
     * @return EmailLink
     */
    public function setHrefnew($hrefnew)
    {
        $this->hrefnew = $hrefnew;
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
        if (ConfigurationUtility::isEnforceChangeTextActivated()) {
            $this->changeText = true;
        } else {
            $this->changeText = GeneralUtility::validEmail($this->getText());
        }
        return $this;
    }
}
