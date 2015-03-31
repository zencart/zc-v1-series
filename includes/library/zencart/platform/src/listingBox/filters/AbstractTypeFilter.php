<?php
/**
 * Class AbstractTypeFilter
 *
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: currencies.php 15880 2010-04-11 16:24:30Z wilt $
 */
namespace ZenCart\Platform\listingBox\filters;
/**
 * Class AbstractTypeFilter
 * @package ZenCart\Platform\listingBox\filters
 */
abstract class AbstractTypeFilter extends AbstractFilter
{
    /**
     * @param array $productQuery
     * @return array
     */
    public function filterItem(array $productQuery)
    {
        if (!$this->request->has('keyword')) {
            $productQuery = $this->handleParameterFilters($productQuery);
        }
        $this->buildOptionFilterVars();
        return $productQuery;
    }

    /**
     *
     */
    public function buildOptionFilterVars()
    {
        if (PRODUCT_LIST_FILTER == 0) {
            return;
        }
        $filterSql = $this->getDefaultFilterSql();
        if (zen_not_null($this->request->readGet($this->getGetTypeParam()))) {
            $filterSql = $this->getTypeFilterSql();
        }
        $this->tplVars['filterOptions'] = array();
        $this->tplVars['doFilterList'] = false;
        $this->tplVars['getOptionSet'] = false;
        if (PRODUCT_LIST_ALPHA_SORTER == 'true') {
            $this->filterVars['doFilterList'] = true;
        }

        $filterlist = $this->dbConn->Execute($filterSql);
        if ($filterlist->RecordCount() > 1) {
            $this->buildFilterList($filterlist);
        }
        if (count($this->tplVars['filterOptions']) == 0) {
            $this->tplVars['doFilterList'] = false;
        }
    }

    /**
     * @param $filterlist
     */
    public function buildFilterList($filterlist)
    {

        $this->tplVars['doFilterList'] = true;
        $this->tplVars['getOptionSet'] = true;
        $this->tplVars['getOptionVariable'] = $this->getGetTypeParam();
        $this->tplVars['filterOptions'] = array(
            array(
                'id' => '',
                'text' => TEXT_ALL_MANUFACTURERS
            )
        );
        if ($this->request->has($this->getGetTypeParam())) {
            $this->tplVars['filterOptions'] = array(
                array(
                    'id' => '',
                    'text' => TEXT_ALL_CATEGORIES
                )
            );
        }
        foreach ($filterlist as $filterOption) {
            $this->tplVars['filterOptions'] [] = array(
                'id' => $filterOption['id'],
                'text' => $filterOption['name']
            );
        }
    }

    /**
     * @param $productQuery
     * @return mixed
     */
    abstract protected function handleParameterFilters($productQuery);

    /**
     * @return mixed
     */
    abstract protected function getGetTypeParam();

    /**
     * @return mixed
     */
    abstract protected function getDefaultFilterSql();

    /**
     * @return mixed
     */
    abstract protected function getTypeFilterSql();
}
