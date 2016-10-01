<?php
namespace In2code\Email2powermail\Utility;

/**
 * Class DomDocumentUtility
 */
class DomDocumentUtility
{

    /**
     * @var string $content
     * @return \DOMDocument
     */
    public static function getDomDocument($content)
    {
        $domDocument = new \DomDocument();
        $domDocument->loadHTML($content);
        return $domDocument;
    }

    /**
     * @param \DOMNode $node
     * @return string
     */
    public static function outerHTML(\DOMNode $node) {
        $doc = new \DomDocument();
        $doc->appendChild($doc->importNode($node, true));
        return trim($doc->saveHTML());
    }
}
