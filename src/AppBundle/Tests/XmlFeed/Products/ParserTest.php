<?php

namespace AppBundle\Tests\XmlFeed\Products;
use AppBundle\XmlFeed\Products\Parser;

/**
 * Test for AppBundle\XmlFeed\Products\Parser
 *
 * @group unit
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->parser = new Parser();
    }

    /**
     * @param string $xmlString
     * @param array  $expectedData
     *
     * @dataProvider parseItemDataProvider
     */
    public function testParseItem($xmlString, $expectedData)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($xmlString);
        $product = $dom->firstChild;
        $this->assertEquals($expectedData, $this->parser->parseItem($product));
    }

    /**
     * @return array
     */
    public function parseItemDataProvider()
    {
        $xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<product>
    <productID>0062-16156</productID> <name>ATTEMA Att Hoofdschakelaar 2p 40A</name> <price currency="EUR">2378.81</price>
    <productURL>http://www.hardware.nl/tt/?tt=541_0_1_&amp;r=attema.hardware.nl%2F16 156</productURL>
    <imageURL />
    <description><![CDATA[Att Hoofdschakelaar 2p 40A]]></description>
    <categories>
        <category path="INSTALLATIEKASTEN">INSTALLATIEKASTEN</category>
        <category path="INSTALLATIEKASTEN2">INSTALLATIEKASTEN2</category>
    </categories>
    <additional>
        <field name="priceExVat">1999.00</field> <field name="EAN">16156</field>
        <field name="deliveryCosts">5.95</field> <field name="deliveryTime">2-6 dagen</field>
    </additional>
</product>
XML;

        return [
            'case 1' => [
                'xmlString' => $xml,
                'expectedData' => [
                    'productID' => '0062-16156',
                    'name' => 'ATTEMA Att Hoofdschakelaar 2p 40A',
                    'price' => '2378.81',
                    'price_currency' => 'EUR',
                    'productURL' => 'http://www.hardware.nl/tt/?tt=541_0_1_&r=attema.hardware.nl%2F16 156',
                    'imageURL' => '',
                    'description' => 'Att Hoofdschakelaar 2p 40A',
                    'categories' => [
                        'INSTALLATIEKASTEN',
                        'INSTALLATIEKASTEN2',
                    ],
                ],
            ],
        ];
    }
}
