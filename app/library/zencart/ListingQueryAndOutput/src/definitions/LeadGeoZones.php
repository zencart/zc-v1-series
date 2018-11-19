<?php
/**
 * @package classes
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id:New in v1.6.0  $
 */
namespace ZenCart\ListingQueryAndOutput\definitions;

/**
 * Class LeadGeoZones
 * @package ZenCart\ListingQueryAndOutput\definitions
 */
class LeadGeoZones extends AbstractLeadDefinition
{
    /**
     *
     */
    public function initQueryAndOutput()
    {
        $this->listingQuery = array(
            'mainTable' => array(
                'table' => TABLE_GEO_ZONES,
                'fkeyFieldLeft' => 'geo_zone_id',
            ),
            'isPaginated' => true,
            'pagination' => array(
                'scrollerParams' => array(
                    'navLinkText' => TEXT_DISPLAY_NUMBER_OF_GEO_ZONES,
                    'pagingVarSrc' => 'post'
                )
            ),

        );

        $this->outputLayout = array(
            'allowDelete' => true,
            'relatedLinks' => array(
                array(
                    'text' => BOX_TAXES_COUNTRIES,
                    'href' => zen_href_link(FILENAME_COUNTRIES)
                ),
                array(
                    'text' => BOX_TAXES_ZONES,
                    'href' => zen_href_link(FILENAME_ZONES)
                ),
                array(
                    'text' => BOX_TAXES_TAX_CLASSES,
                    'href' => zen_href_link(FILENAME_TAX_CLASSES)
                ),
                array(
                    'text' => BOX_TAXES_TAX_RATES,
                    'href' => zen_href_link(FILENAME_TAX_RATES)
                )
            ),
            'listMap' => array(
                'geo_zone_id',
                'geo_zone_name',
                'geo_zone_description',
                'status'
            ),
            'editMap' => array(
                'geo_zone_id',
                'geo_zone_name',
                'geo_zone_description',
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
            'headerTemplate' => 'tplAdminLeadGeoZonesHeader.php',
            'extraRowActions' => array(
                    array(
                        'key' => 'edit',
                        'link' => array(
                            'cmd' => FILENAME_GEO_ZONES,
                            'params' => array(
                                array(
                                    'type' => 'text',
                                    'name' => 'action',
                                    'value' => 'edit'
                                ),
                                array(
                                    'type' => 'item',
                                    'name' => 'geo_zone_id',
                                    'value' => 'geo_zone_id'
                                )
                            )
                        ),
                        'linkText' => TEXT_LEAD_EDIT_GEO_ZONE
                    ),
                    array(
                    'key' => 'edit_sub_zone',
                    'link' => array(
                        'cmd' => FILENAME_GEO_ZONES_DETAIL,
                        'params' => array(
                            array(
                                'type' => 'item',
                                'name' => 'geo_zone_id',
                                'value' => 'geo_zone_id'
                            )
                        )
                    ),
                    'linkText' => TEXT_LINK_DETAILS
                ),
            ),
            'fields' => array(
                'geo_zone_id' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'common' => array(
                            'title' => TEXT_ENTRY_COUNTRY_ZONE,
                            'align' => 'left'
                        )
                    )
                ),
                'geo_zone_name' => array(
                    'bindVarsType' => 'string',
                    'layout' => array(
                        'common' => array(
                            'title' => TEXT_ENTRY_TAX_ZONES,
                            'type' => 'text',
                            'size' => '30'
                        )
                    )
                ),
                'geo_zone_description' => array(
                    'bindVarsType' => 'string',
                    'layout' => array(
                        'common' => array(
                            'title' => TEXT_ENTRY_TAX_ZONES_DESCRIPTION,
                            'align' => 'right',
                            'type' => 'text',
                            'size' => '20'
                        )
                    )
                ),
                'status' => array(
                    'bindVarsType' => 'integer',
                    'layout' => array(
                        'common' => array(
                            'title' => TEXT_ENTRY_GEO_ZONES_STATUS,
                            'align' => 'right',
                            'type' => 'hidden',
                            'size' => '20'
                        )
                    ),
                    'fieldFormatter' => array(
                        'callable' => 'zoneStatusIcon'
                    )
                )
            ),
        );
    }
}
