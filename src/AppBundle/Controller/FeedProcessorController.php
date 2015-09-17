<?php

namespace AppBundle\Controller;

use AppBundle\XmlFeed\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FeedProcessorController
 *
 * @Route("/")
 */
class FeedProcessorController extends Controller
{
    /**
     * Render index page
     *
     * @Route("", name="app_feed_processor_index")
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:FeedProcessor:index.html.twig');
    }

    /**
     * Fetch products from xml feed
     *
     * @param Request $request
     *
     * @Route("products.json", name="app_feed_processor_products", requirements={"_format"="json"})
     * @Method("GET")
     *
     * @return Response
     */
    public function getProductsAction(Request $request)
    {
        $xmlUrl = $request->get('xml');
        $limit = $request->get('limit', 100);
        $offset = $request->get('offset', 0);

        /** @var Reader $feedReader */
        $feedReader = $this->get('app.xml_feed.reader.products');
        $products = [];
        $totalItemsInFeed = $feedReader->readXml($xmlUrl, $products, $offset, $limit);

        return new JsonResponse([
            'totalItemsInFeed' => $totalItemsInFeed,
            'products' => $products,
        ]);
    }
}
