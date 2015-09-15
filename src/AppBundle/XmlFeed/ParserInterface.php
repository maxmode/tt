<?php

namespace AppBundle\XmlFeed;


interface ParserInterface
{
    /**
    * Parse item from xml
    *
    * @param \DOMNode $dom
    *
    * @return \stdClass
    */
    public function parseItem(\DOMNode $dom);
}
