<?php

namespace App\Models\WebServiceCaixa;

use DOMDocument;
use DOMElement;

class XmlDomConstruct extends DOMDocument
{
    /**
     * CONSTRUCTS ELEMENTS AND TEXTS FROM AN ARRAY OR STRING.
     * THE ARRAY CAN CONTAIN AN ELEMENT'S NAME IN THE INDEX PART
     * AND AN ELEMENT'S TEXT IN THE VALUE PART.
     *
     * IT CAN ALSO CREATE AN XML WITH THE SAME ELEMENT TAGNAME ON THE SAME
     * LEVEL.
     *
     * @param mixed $mixed AN ARRAY OR STRING.
     * @param DomElement|null $domElement
     */
    public function fromMixed($mixed, DOMElement $domElement = null)
    {
        $domElement = is_null($domElement) ? $this : $domElement;
        if (is_array($mixed)) {
            foreach ($mixed as $index => $mixedElement) {
                if (is_int($index)) {
                    if ($index == 0) {
                        $node = $domElement;
                    } else {
                        $node = $this->createElement($domElement->tagName);
                        $domElement->parentNode->appendChild($node);
                    }
                } else {
                    $node = $this->createElement($index);
                    $domElement->appendChild($node);
                }

                $this->fromMixed($mixedElement, $node);
            }
        } else {
            $domElement->appendChild($this->createTextNode($mixed));
        }
    }
}
