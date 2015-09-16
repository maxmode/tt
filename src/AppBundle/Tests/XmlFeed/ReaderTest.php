<?php

namespace AppBundle\Tests\XmlFeed;
use AppBundle\XmlFeed\Products\Parser;
use AppBundle\XmlFeed\Reader;

/**
 * Test for AppBundle\XmlFeed\Reader
 *
 * @group integration
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $parser = new Parser();
        $this->reader = new Reader($parser);
    }

    /**
     * @param string $url
     * @param int    $expectedTotalCount
     * @param int    $expectedProductCount
     * @param int    $memoryLimit
     * @param int    $offset
     * @param int    $limit
     *
     * @dataProvider readXmlDataProvider
     */
    public function testReadXml($url, $expectedTotalCount, $expectedProductCount, $memoryLimit, $offset, $limit)
    {
        $items = [];
        $totalCount = $this->reader->readXml($url, $items, $offset, $limit);
        $this->assertEquals($expectedTotalCount, $totalCount);
        $this->assertCount($expectedProductCount, $items);
        $this->assertLessThan($memoryLimit, memory_get_peak_usage(true));
    }

    /**
     * @return array
     */
    public function readXmlDataProvider()
    {
        return [
            '10 products, zero limit test' => [
                'url' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=10',
                'expectedTotalCount' => 10,
                'expectedProductCount' => 10,
                'memoryLimit' => 32 * 2 ** 20,
                'offset' => 0,
                'limit' => 0,
            ],
            '10000 products feed, first 100' => [
                'url' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=10000',
                'expectedTotalCount' => 10000,
                'expectedProductCount' => 100,
                'memoryLimit' => 32 * 2 ** 20,
                'offset' => 0,
                'limit' => 100,
            ],
            '10000 products feed, last 100' => [
                'url' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=10000',
                'expectedTotalCount' => 10000,
                'expectedProductCount' => 100,
                'memoryLimit' => 32 * 2 ** 20,
                'offset' => 9900,
                'limit' => 100,
            ],
            '100 000 products feed, last 100' => [
                'url' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=100000',
                'expectedTotalCount' => 100000,
                'expectedProductCount' => 100,
                'memoryLimit' => 32 * 2 ** 20,
                'offset' => 99900,
                'limit' => 100,
            ]
        ];
    }
}
