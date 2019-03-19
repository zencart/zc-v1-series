<?php
/**
 * Class NewProductsCenter
 *
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id:  wilt  New in v1.6.0 $
 */
namespace ZenCart\ListingQueryAndOutput\definitions;

/**
 * Class NewProductsCenter
 * @package ZenCart\ListingQueryAndOutput\definitions
 */
class NewProductsCenter extends AbstractDefinition
{
    /**
     *
     */
    public function initQueryAndOutput()
    {
        $this->listingQuery = array(
            'mainTable' => array(
                'table' => TABLE_PRODUCTS,
                'fkeyFieldLeft' => 'products_id',
            ),
            'derivedItems' => array(
                array(
                    'field' => 'productCpath',
                    'handler' => 'productCpathBuilder'
                ),
                array( // must happen after productCpathBuilder
                    'field' => 'link',
                    'handler' => 'productLinkBuilder'
                ),
                array( // must happen after productLinkBuilder
                    'field' => 'displayPrice',
                    'handler' => 'displayPriceBuilder'
                ),
                array( // must happen after displayPriceBuilder
                    'field' => 'displayFreeTag',
                    'handler' => 'displayFreeTagBuilder'
                ),
                array( // must happen after displayPriceBuilder
                    'field' => 'priceBlock',
                    'handler' => 'priceBlockBuilder'
                ),
            ),
            'filters' => array(
                array(
                    'name' => 'CategoryFilter',
                    'parameters' => array()
                ),
            ),
            'queryLimit' => MAX_DISPLAY_NEW_PRODUCTS,
            'joinTables' => array(
                'TABLE_PRODUCTS_DESCRIPTION' => array(
                    'table' => TABLE_PRODUCTS_DESCRIPTION,
                    'type' => 'left',
                    'fkeyFieldLeft' => 'products_id',
                    'addColumns' => true
                )
            ),
            'whereClauses' => array(
                array(
                    'table' => TABLE_PRODUCTS,
                    'field' => 'products_status',
                    'value' => 1,
                    'type' => 'AND'
                ),
                array(
                    'table' => TABLE_PRODUCTS_DESCRIPTION,
                    'field' => 'language_id',
                    'value' => $this->request->getSession()->get('languages_id'),
                    'type' => 'AND'
                ),
                array(
                    'custom' => zen_get_new_date_range()
                )
            ),
            'orderBys' => array(
                array(
                    'field' => 'RAND()',
                    'type' => 'mysql'
                ),
            )
        );
        $this->outputLayout = array(
            'boxTitle' => sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')),
            'formatter' => array('class' => 'Columnar',
                                 'template' => 'tpl_listingbox_columnar.php',
                                 'params' => array(
                                     'columnCount' => SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS),
                                 'sortMainPage' => SHOW_PRODUCT_INFO_MAIN_NEW_PRODUCTS 
            ),
        );
    }
}
