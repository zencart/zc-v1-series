<?php
/**
 * Class TypeFilterRecordCompany
 *
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: currencies.php 15880 2010-04-11 16:24:30Z wilt $
 */
namespace ZenCart\Platform\listingBox\filters;
/**
 * Class TypeFilterRecordCompany
 * @package ZenCart\Platform\listingBox\filters
 */
class TypeFilterRecordCompany extends AbstractTypeFilter
{
    /**
     * @param $productQuery
     * @return mixed
     */
    public function handleParameterFilters($productQuery)
    {
        $productQuery['selectList'] [] = "r.record_company_name as manufacturers_name";

        $productQuery['joinTables'] ['TABLE_PRODUCT_MUSIC_EXTRA'] = array(
            'table' => TABLE_PRODUCT_MUSIC_EXTRA,
            'alias' => 'pme',
            'type' => 'LEFT',
            'fkeyFieldLeft' => 'products_id'
        );
        $productQuery['joinTables'] ['TABLE_RECORD_COMPANY'] = array(
            'table' => TABLE_RECORD_COMPANY,
            'alias' => 'r',
            'type' => 'LEFT',
            'fkeyFieldLeft' => 'record_company_id',
            'fkeyTable' => 'TABLE_PRODUCT_MUSIC_EXTRA'
        );
        if ($this->request->readGet('record_company_id')) {
            $productQuery['whereClauses'] [] = array(
                'table' => TABLE_RECORD_COMPANY,
                'field' => 'record_company_id',
                'value' => (int)$this->request->readGet('record_company_id'),
                'type' => 'AND'
            );
            if ($this->request->readGet('filter_id')) {
                $productQuery['joinTables'] ['TABLE_PRODUCTS_TO_CATEGORIES'] = array(
                    'table' => TABLE_PRODUCTS_TO_CATEGORIES,
                    'alias' => 'p2c',
                    'type' => 'LEFT',
                    'fkeyFieldLeft' => 'products_id'
                );
                $productQuery['whereClauses'] [] = array(
                    'table' => TABLE_PRODUCTS_TO_CATEGORIES,
                    'field' => 'categories_id',
                    'value' => (int)$this->request->readGet('filter_id'),
                    'type' => 'AND'
                );
            }
        } else {
            $productQuery['joinTables'] ['TABLE_PRODUCTS_TO_CATEGORIES'] = array(
                'table' => TABLE_PRODUCTS_TO_CATEGORIES,
                'alias' => 'p2c',
                'type' => 'LEFT',
                'fkeyFieldLeft' => 'products_id'
            );
            $productQuery['whereClauses'] [] = array(
                'table' => TABLE_PRODUCTS_TO_CATEGORIES,
                'field' => 'categories_id',
                'value' => (int)$this->params['currentCategoryId'],
                'type' => 'AND'
            );
            if ($this->request->readGet('filter_id')) {
                $productQuery ['whereClauses'] [] = array(
                    'table' => TABLE_RECORD_COMPANY,
                    'field' => 'record_company_id',
                    'value' => (int)$this->request->readGet('filter_id'),
                    'type' => 'AND'
                );
            }
        }

        return $productQuery;
    }

    /**
     * @return string
     */
    protected function getGetTypeParam()
    {
        return 'record_company';
    }

    /**
     * @return string
     */
    protected function getDefaultFilterSql()
    {
        $sql = "SELECT DISTINCT r.record_company_id AS id, r.record_company_name AS name
                FROM  " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_PRODUCT_MUSIC_EXTRA . " pme, " . TABLE_RECORD_COMPANY . " r
                WHERE p.products_status = 1
                AND pme.record_company_id = r.record_company_id
                AND p.products_id = p2c.products_id
                AND pme.products_id = p.products_id
                AND p2c.categories_id = '" . (int)$this->params['currentCategoryId'] . "'
                ORDER BY r.record_company_name";
        return $sql;
    }

    /**
     * @return string
     */
    protected function getTypeFilterSql()
    {
        $sql = "SELECT DISTINCT c.categories_id AS id, cd.categories_name AS name
                FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_PRODUCT_MUSIC_EXTRA . " pme, " . TABLE_RECORD_COMPANY . " r
                WHERE p.products_status = 1
                AND p.products_id = pme.products_id
                AND pme.products_id = p2c.products_id
                AND pme.record_company_id = r.record_company_id
                AND p2c.categories_id = c.categories_id
                AND p2c.categories_id = cd.categories_id
                AND cd.language_id = '" . (int)$_SESSION ['languages_id'] . "'
                AND r.record_company_id = '" . (int)$this->request->readGet('record_company_id') . "'
                ORDER BY cd.categories_name";
        return $sql;
    }
}
