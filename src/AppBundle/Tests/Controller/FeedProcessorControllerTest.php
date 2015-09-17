<?php

namespace AppBundle\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test for FeedProcessorController
 *
 * @group functional
 */
class FeedProcessorControllerTest extends WebTestCase
{
    /**
     * Test for products feed
     *
     * @dataProvider getProductsActionDataProvider
     */
    public function testGetProductsAction($xml, $offset, $limit, $expectedProductsCount, $expectedTotalSize)
    {
        $client = static::createClient();

        $query = http_build_query([
            'xml' => $xml,
            'offset' => $offset,
            'limit' => $limit,
        ]);
        $client->request('GET', '/products.json?' . $query);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('products', $response);
        $this->assertCount($expectedProductsCount, $response['products']);
        $this->assertArrayHasKey('totalItemsInFeed', $response);
        $this->assertEquals($expectedTotalSize, $response['totalItemsInFeed']);
    }

    /**
     * @return array
     */
    public function getProductsActionDataProvider()
    {
        return [
            'case 1' => [
                'xml' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=1000',
                'offset' => 0,
                'limit' => 100,
                'expectedProductsCount' => 100,
                'expectedTotalSize' => 1000,
            ],
        ];
    }

    /**
     * Test for index page
     */
    public function testIndexAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('text/html', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('XML Feed processor', $crawler->text());
    }
}
