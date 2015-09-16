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

    /**
     * Define, what tag represent an item in big xml
     *
     * @return string
     */
    public function getItemTagName();
}
