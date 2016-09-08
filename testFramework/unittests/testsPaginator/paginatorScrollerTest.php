<?php
/**
 * File contains Paginator Scroller test cases
 *
 * @package tests
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id$
 */
require_once(__DIR__ . '/../support/zcTestCase.php');
use ZenCart\Paginator\scrollers\Standard;

/**
 * Testing Library
 */
class testPaginationScrollerCase extends zcTestCase
{
    public function setUp()
    {
        parent::setUp();
//        require_once(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'sessions.php');
        require DIR_FS_CATALOG . 'includes/functions/functions_general.php';
        require_once(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'html_output.php');
        define('SEARCH_ENGINE_FRIENDLY_URLS', false);
        define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', '');
        $loader = new \Aura\Autoload\Loader;
        $loader->register();
        $loader->addPrefix('\ZenCart\Paginator', DIR_CATALOG_LIBRARY . 'zencart/Paginator/src');
    }

    public function testRunScrollerWithResults()
    {
        $GLOBALS['request_type'] = 'NONSSL';
        $ds = $this->getMockBuilder('\\ZenCart\\Paginator\\adapters\\SqlQuery')
            ->disableOriginalConstructor()
            ->getMock();
        $ds->method('getResults')->willReturn(array(
            'totalItemCount' => 100,
            'totalPages' => 10,
            'currentItem' => 1,
            'itemsPerPage' => 10,
            'resultList' => array()
        ));
        $params = array(
            'pagingVarName' => 'page',
            'scrollerLinkParams' => '',
            'itemsPerPage' => '10',
            'currentItem' => '1',
            'currentPage' => '1',
            'maxPageLinks' => '10',
            'cmd' => 'countries'
        );
        $scroller = new Standard($ds, $params);
        $dsr = $scroller->getResults();
        $this->assertTrue(is_array($dsr));
        $this->assertTrue(is_array($dsr['linkList']));
        $this->assertTrue($dsr['hasItems']);
        $this->assertTrue($dsr['nextPage'] == 2);
        $this->assertTrue($dsr['prevPage'] == 0);
    }

    public function testRunScrollerWithNoResults()
    {
        $GLOBALS['request_type'] = 'NONSSL';
        $ds = $this->getMockBuilder('\\ZenCart\\Paginator\\adapters\\SqlQuery')
            ->disableOriginalConstructor()
            ->getMock();
        $ds->method('getResults')->willReturn(array(
            'totalItemCount' => 0,
            'totalPages' => 0,
            'currentItem' => 1,
            'itemsPerPage' => 10,
            'resultList' => array()
        ));
        $params = array(
            'pagingVarName' => 'page',
            'scrollerLinkParams' => '',
            'itemsPerPage' => '10',
            'currentItem' => '0',
            'currentPage' => '0',
            'maxPageLinks' => '10',
            'totalPages' => '0',
            'cmd' => 'countries'
        );
        $scroller = new Standard($ds, $params);
        $dsr = $scroller->getResults();
        $this->assertTrue(is_array($dsr));
        $this->assertTrue(is_array($dsr['linkList']));
        $this->assertFalse($dsr['hasItems']);
        $this->assertTrue($dsr['nextPage'] == 1);
        $this->assertTrue($dsr['prevPage'] == -1);
    }
}
