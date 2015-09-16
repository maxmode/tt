<?php

namespace AppBundle\XmlFeed;

/**
 * Read XML feed and split it into pieces per product
 */
class Reader
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string $url
     * @param array  &$items
     * @param int    $offsetItems
     * @param int    $limitItems
     *
     * @return int Count of items in whole feed
     */
    public function readXml($url, &$items, $offsetItems = 0, $limitItems = 0)
    {

        $z = new \XMLReader;
        $z->open($url);
        $items = [];
        $index = 0;

        while ($z->read() && $z->name !== $this->parser->getItemTagName()) {
        }

        while ($z->name === $this->parser->getItemTagName())
        {
            if ($index >= $offsetItems && ($index < ($limitItems + $offsetItems) || $limitItems == 0 )) {
                $items[] = $this->parser->parseItem($z->expand());
            }
            $z->next($this->parser->getItemTagName());
            if ($index++ % 100 == 0) {
                gc_collect_cycles();
            }
        }

        return $index;
    }
}
