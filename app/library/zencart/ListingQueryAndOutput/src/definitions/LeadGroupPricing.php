<?php
/**
 * Class LeadGroupPricing
 *
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id:$
 */
namespace ZenCart\ListingQueryAndOutput\definitions;

/**
 * Class LeadGroupPricing
 * @package ZenCart\ListingQueryAndOutput\definitions
 */
class LeadGroupPricing extends AbstractLeadDefinition
{
    /**
     *
     */
    public function initQueryAndOutput()
    {

        $linkedCustomers = function ($item, $key, $pkey) {
            $count = $this->mainModel->withCount('customers')->find($item[$pkey])->customers_count;
            return $count;
        };

        $this->listingQuery = array(
            'mainTable' => array(
                'table' => TABLE_GROUP_PRICING,
                'fkeyFieldLeft' => 'group_id',
            ),
            'isPaginated' => true,
            'pagination' => array(
                'scrollerParams' => array(
                    'navLinkText' => TEXT_DISPLAY_NUMBER_OF_PRICING_GROUPS,
                    'pagingVarSrc' => 'post'
                )
            ),
        );

        $this->outputLayout = array(

            'allowDelete' => true,
            'relatedLinks' => array(
                array(
                    'text' => BOX_CUSTOMERS_CUSTOMERS,
                    'href' => zen_href_link(FILENAME_CUSTOMERS)
                ),
            ),
            'listMap' => array(
                'group_id',
                'group_name',
                'group_percentage',
                'linked_customers'
            ),
            'editMap' => array(
                'group_name',
                'group_percentage',
            ),
            'autoMap' => array(
                'add' => array(
                    array(
                        'field' => 'date_added',
                        'value' => 'now()',
                        'bindVarsType' => 'passthru'
                    )
                ),
                'edit' => array(
                    array(
                        'field' => 'last_modified',
                        'value' => 'now()',
                        'bindVarsType' => 'passthru'
                    )
                )
            ),
            'fields' => array(
                'group_id' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_GROUP_ID,
                            'align' => 'right',
                            'size' => '30'
                        )
                    )
                ),
                'group_name' => array(
                    'bindVarsType' => 'string',
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_GROUP_NAME,
                            'type' => 'text',
                            'align' => 'right',
                            'size' => '30'
                        )
                    )
                ),
                'group_percentage' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'common' => array(
                            'title' => TABLE_HEADING_GROUP_AMOUNT,
                            'align' => 'right',
                            'type' => 'text',
                            'size' => '30'
                        )
                    ),
                ),
                'linked_customers' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'list' => array(
                            'title' => TEXT_ENTRY_LINKED_CUSTOMERS,
                            'size' => '30'
                        )
                    ),
                    'fieldFormatter' => array(
                        'callable' => $linkedCustomers
                    )
                ),
            ),
        );
    }
}
