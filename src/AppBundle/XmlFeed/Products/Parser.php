<?php

namespace AppBundle\XmlFeed\Products;
use AppBundle\XmlFeed\ParserInterface;

/**
 * Parse product out of product xml
 */
class Parser implements ParserInterface
{
    /**
     * Parse product from xml
     *
     * @param \DOMNode $dom
     *
     * @return \stdClass
     */
    public function parseItem(\DOMNode $dom)
    {
        $product = [];
        $flatAttributes = ['productID', 'name', 'description', 'productURL', 'imageURL'];
        /** @var \DOMNode $node */
        foreach ($dom->childNodes as $node) {
            if (in_array($node->nodeName, $flatAttributes)) {
                $product[$node->nodeName] = $node->nodeValue;
            } elseif ($node->nodeName == 'price') {
                $product['price'] = $node->nodeValue;
                $product['price_currency'] = $node->attributes->getNamedItem('currency')->nodeValue;
            } elseif ($node->nodeName == 'categories') {
                $product['categories'] = [];
                /** @var \DOMNode $category */
                foreach ($node->childNodes as $category) {
                    if ($category->nodeName == 'category') {
                        $product['categories'][] = $category->nodeValue;
                    }
                }
            };
        }

        return $product;
    }
}
