<?php
/**
 * Class Index
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id:$
 */
namespace ZenCart\ListingQueryAndOutput\definitions;

/**
 * Class ReportStatsCustomers
 * @package ZenCart\ListingQueryAndOutput\definitions
 */
class ReportStatsCustomers extends AbstractLeadDefinition
{
    /**
     *
     */
    public function initQueryAndOutput()
    {

        $customersName = function ($resultItem) {
            return $resultItem['customers_firstname'] . ' ' . $resultItem['customers_lastname'];
        };
        $currencyFormat = function ($item, $key, $pkey) {
            $currencies = new \currencies();
            return $currencies->format($item['ordersum']);
        };
        $this->listingQuery = array(
            'mainTable' => array(
                'table' => TABLE_CUSTOMERS,
                'fkeyFieldLeft' => 'customers_id',
            ),
            'joinTables' => array(
                'TABLE_ORDERS' => array(
                    'table' => TABLE_ORDERS,
                    'type' => 'left',
                    'fkeyFieldLeft' => 'customers_id',
                    'fkeyFieldRight' => 'customers_id',
                ),
                'TABLE_ORDERS_PRODUCTS' => array(
                    'table' => TABLE_ORDERS_PRODUCTS,
                    'fkeyTable' => 'TABLE_ORDERS',
                    'type' => 'left',
                    'fkeyFieldLeft' => 'orders_id',
                    'fkeyFieldRight' => 'orders_id',
                ),
            ),
            'selectList' => array(TABLE_CUSTOMERS . '.customers_id, ' . TABLE_CUSTOMERS . '.customers_firstname, ' . TABLE_CUSTOMERS . '.customers_lastname, sum(' . TABLE_ORDERS_PRODUCTS. '.products_quantity * ' . TABLE_ORDERS_PRODUCTS . '.final_price)+sum(' . TABLE_ORDERS_PRODUCTS . '.onetime_charges)  as ordersum'),
            'groupBys' => array('customers_id, customers_firstname, customers_lastname'),
            'orderBys' => array(array('field' => 'ordersum DESC')),
            'isPaginated' => true,
            'pagination' => array(
                'scrollerParams' => array(
                    'navLinkText' => TEXT_DISPLAY_NUMBER_OF_CUSTOMERS,
                    'pagingVarSrc' => 'post'
                )
            ),

            'derivedItems' => array(
                array(
                    'context' => 'list',
                    'field' => 'customers_name',
                    'handler' => $customersName
                ),
            ),
        );

        $this->outputLayout = array(


            'listMap' => array(
                'customers_id',
                'customers_name',
                'ordersum',
            ),
            'fields' => array(
                'customers_id' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_NUMBER,
                            'align' => 'left'
                        )
                    ),
                    'total' => 'count',
                ),
                'customers_name' => array(
                    'bindVarsType' => 'string',
                    'language' => true,
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_CUSTOMERS,
                            'align' => 'right',
                            'size' => '30'
                        )
                    )
                ),
                'customers_firstname' => array(
                    'bindVarsType' => 'string',
                    'language' => true,
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_CUSTOMERS_NAME,
                            'align' => 'right',
                            'size' => '30'
                        )
                    )
                ),
                'customers_lastname' => array(
                    'bindVarsType' => 'string',
                    'language' => true,
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_CUSTOMERS_NAME,
                            'align' => 'right',
                            'size' => '30'
                        )
                    )
                ),
                'ordersum' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_TOTAL_PURCHASED,
                            'align' => 'left',
                        )
                    ),
                    'fieldFormatter' => array(
                        'callable' => $currencyFormat
                    ),
                    'total' => 'currencySum',
                ),
            ),
        );
    }
}
