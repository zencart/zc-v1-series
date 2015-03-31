<?php
/**
 * Class QueryBuilder
 *
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: $
 */
namespace ZenCart\Platform;
//use ZenCart\ListingBox\DerivedItems;
/**
 * Class QueryBuilder
 * @package ZenCart\Platform
 */
class QueryBuilder extends \base
{
    /**
     * @var
     */
    protected $dbConn;
    /**
     * query parts
     *
     * @var array
     */
    protected $parts;
    /**
     * query
     *
     * @var array
     */
    protected $query;

    /**
     * @param array $productQuery
     */
    public function __construct($dbConn, array $productQuery = array())
    {
        $this->dbConn = $dbConn;
        $this->parts = null;
        if (count($productQuery) > 0) {
            $this->initParts($productQuery);
        }
    }
    public function initParts(array $productQuery)
    {
        $this->notify('NOTIFY_QUERY_BUILDER_INIT_START');
        $this->parts ['bindVars'] = issetorArray($productQuery, 'bindVars', array());
        $this->parts ['selectList'] = issetorArray($productQuery, 'selectList', array());
        $this->parts ['orderBys'] = issetorArray($productQuery, 'orderBys', array());
        $this->parts ['filters'] = issetorArray($productQuery, 'filters', array());
        $this->parts ['derivedItems'] = issetorArray($productQuery, 'derivedItems', array());
        $this->parts ['joinTables'] = issetorArray($productQuery, 'joinTables', array());
        $this->parts ['whereClauses'] = issetorArray($productQuery, 'whereClauses', array());
        $this->parts ['mainTableName'] = TABLE_PRODUCTS;
        $this->parts ['mainTableAlias'] = 'p';
        $this->parts ['mainTableFkeyField'] = 'products_id';
        if (isset($productQuery['mainTable'])) {
            $this->parts ['mainTableName'] = $productQuery['mainTable'] ['table'];
            $this->parts ['mainTableAlias'] = $productQuery['mainTable'] ['alias'];
            $this->parts ['mainTableFkeyField'] = $productQuery['mainTable'] ['fkeyFieldLeft'];
        }
        $this->parts ['tableAliases'] [$this->parts ['mainTableName']] = $this->parts ['mainTableAlias'];
        $this->notify('NOTIFY_QUERY_BUILDER_INIT_END');
    }

    /**
     * process query
     *
     */
    public function processQuery($productQuery)
    {
        if (!isset($this->parts)) {
            $this->initParts($productQuery);
        }
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSQUERY_START');
        $this->query ['select'] = "SELECT " . (issetorArray($productQuery, 'isDistinct', false) ? ' DISTINCT ' : '') . $this->parts ['mainTableAlias'] . ".*";
        $this->preProcessJoins();
        $this->query ['joins'] = '';
        $this->query ['table'] = ' FROM ';
        $this->processJoins();
        $this->query ['table'] .= $this->parts ['mainTableName'] . " AS " . $this->parts ['mainTableAlias'] . " ";
        $this->processWhereClause();
        $this->processOrderBys();
        $this->processSelectList();
        $this->setFinalQuery($productQuery);
        $this->processBindVars();
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSQUERY_END');
    }

    protected function setFinalQuery($productQuery)
    {
        $this->query['mainSql'] = $this->query ['select'] . $this->query ['table'] .
            $this->query ['joins'] . $this->query ['where'] . $this->query ['orderBy'];
        if (!isset($this->query['countSql'])) {
            $this->query['countSql'] = "SELECT COUNT(" . (issetorArray($productQuery, 'isDistinct', false) ? "DISTINCT " : '') .
                $this->parts ['mainTableAlias'] . "." . $this->parts ['mainTableFkeyField'] . ")
                                 AS total " . $this->query ['table'] . $this->query ['joins'] .
                $this->query ['where'];;
        }
    }
    /**
     * preprocess joins
     *
     */
    protected function preProcessJoins()
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PREPROCESSJOINS_START');
        if (count($this->parts ['joinTables']) == 0) {
            return;
        }
        foreach ($this->parts ['joinTables'] as $joinTable) {
            $this->parts ['tableAliases'] [$joinTable ['table']] = $joinTable ['alias'];
        }
        $this->query ['joins'] = '';
        $this->notify('NOTIFY_QUERY_BUILDER_PREPROCESSJOINS_END');
    }

    /**
     * process joins
     *
     */
    protected function processJoins()
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINS_START');
        if (count($this->parts ['joinTables']) == 0) {
            return;
        }
        foreach ($this->parts ['joinTables'] as $joinTable) {
            $this->query ['joins'] .= strtoupper($joinTable ['type']) . " JOIN " . $joinTable ['table'] . ' AS ' . $joinTable ['alias'];
            $this->processJoinFkeyField($joinTable);
            $this->processJoinCustomAnd($joinTable);
            $this->processJoinAddColumns($joinTable);
        }
        $this->query ['table'] .= "(";
        $this->query ['joins'] .= ")";
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINS_END');
    }

    /**
     * process join custom adds
     *
     * @param $joinTable
     */
    protected function processJoinCustomAnd($joinTable)
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINSCUSTOMAND_START');
        if (isset($joinTable ['customAnd'])) {
            $this->query ['joins'] .= " " . $joinTable ['customAnd'] . " ";
        }
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINSCUSTOMAND_END');
    }

    /**
     * process join add columns
     *
     * @param $joinTable
     */
    protected function processJoinAddColumns($joinTable)
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINADDCOLUMN_START');
        if (isset($joinTable ['addColumns']) && $joinTable ['addColumns']) {
            $this->query ['select'] .= ", " . $joinTable ['alias'] . ".*";
        }
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINADDCOLUMN_ENDT');
    }

    /**
     * process join foreign keys
     *
     * @param $joinTable
     */
    protected function processJoinFkeyField($joinTable)
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINFKEYFIELD_START');
        $fkeyFieldLeft = $this->parts ['mainTableAlias'] . '.' . $this->parts ['mainTableFkeyField'];
        $fkeyFieldRight = $joinTable ['alias'] . '.' . $this->parts ['mainTableFkeyField'];
        if (!isset($joinTable ['fkeyFieldLeft'])) {
            $this->query ['joins'] .= " ON " . $fkeyFieldLeft . " = " . $fkeyFieldRight . " ";
            return;

        }
        $fkeyFieldLeft = $this->parts ['mainTableAlias'] . '.' . $joinTable ['fkeyFieldLeft'];
        if (isset($joinTable ['fkeyTable'])) {
            $fkeyFieldLeft = $this->parts ['tableAliases'] [constant($joinTable ['fkeyTable'])] . '.' . $joinTable ['fkeyFieldLeft'];
        }
        $fkeyFieldRight = $joinTable ['alias'] . '.' . $joinTable ['fkeyFieldLeft'];
        if (isset($joinTable ['fkeyFieldRight'])) {
            $fkeyFieldRight = $joinTable ['alias'] . '.' . $joinTable ['fkeyFieldRight'];
        }
        $this->query ['joins'] .= " ON " . $fkeyFieldLeft . " = " . $fkeyFieldRight . " ";
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSJOINFKEYFIELD_END');
    }

    /**
     * process where clauses
     */
    protected function processWhereClause()
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSWHERECLAUSE_START');
        $this->query ['where'] = ' WHERE 1';
        if (count($this->parts ['whereClauses']) == 0) {
            return;
        }
        foreach ($this->parts ['whereClauses'] as $whereClause) {
            if (isset($whereClause ['custom'])) {
                $this->query ['where'] .= " " . trim($whereClause ['custom']) . " ";
                continue;
            }
            $this->processWhereClauseTest($whereClause);
        }
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSWHERECLAUSE_END');
    }

    /**
     * process where clauses test
     *
     * @param $whereClause
     */
    protected function processWhereClauseTest($whereClause)
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSWHERECLAUSETEST_START');
        if (!isset($whereClause ['test'])) {
            $whereClause ['test'] = '=';
        }
        $default = ' ' . $whereClause ['test'] . ' ' . $whereClause ['value'];
        $hashMap = array('IN' => " IN ( " . $whereClause ['value'] . " ) ",
                         'LIKE' => " LIKE " . $whereClause ['value'] . " ");

        $addTest = (isset($hashMap[strtoupper($whereClause ['test'])])) ? $hashMap[strtoupper($whereClause ['test'])] : $default;
        $this->query['where'] .= " " . $whereClause ['type'] . " " . $this->parts ['tableAliases'] [$whereClause ['table']] . "." . $whereClause ['field'] . $addTest;
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSWHERECLAUSETEST_END');
    }

    /**
     * process orderBy clauses
     */
    protected function processOrderBys()
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSORDERBYS_START');
        $this->query ['orderBy'] = "";
        if (count($this->parts ['orderBys']) == 0) {
            return;
        }
        $this->query ['orderBy'] = " ORDER BY ";
        foreach ($this->parts ['orderBys'] as $orderBy) {
            $result = $this->processOrderByEntry($orderBy);
            if ($result) {
                continue;
            }
        }
        if (substr($this->query ['orderBy'], strlen($this->query ['orderBy']) - 2) == ', ') {
            $this->query ['orderBy'] = substr($this->query ['orderBy'], 0, strlen($this->query ['orderBy']) - 2) . " ";
        }
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSORDERBYS_END');
    }

    protected function processOrderByEntry($orderBy)
    {
        if ($orderBy ['type'] == 'mysql') {
            $this->query ['orderBy'] .= ' ' . $orderBy ['field'] . ', ';
            return true;
        }
        if (isset($orderBy ['table'])) {
            $this->query ['orderBy'] .= $this->parts ['tableAliases'] [$orderBy ['table']] . ".";
        }
        $this->query ['orderBy'] .= $orderBy ['field'] . ", ";
        return false;
    }

    /**
     * process select list entries
     */
    protected function processSelectList()
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSSELECTLIST_START');
        if (count($this->parts ['selectList']) == 0) {
            return;
        }
        foreach ($this->parts ['selectList'] as $selectList) {
            $this->query ['select'] .= ", " . $selectList;
        }
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSSELECTLIST_END');
    }

    /**
     * process bindVars clauses
     */
    protected function processBindVars()
    {
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSBINDVARS_START');
        if (count($this->parts ['bindVars']) == 0) {
            return;
        }
        foreach ($this->parts ['bindVars'] as $bindVars) {
            $this->query['mainSql'] = $this->dbConn->bindVars($this->query['mainSql'], $bindVars [0], $bindVars [1], $bindVars [2]);
            if (isset($this->query['countSql'])) {
                $this->query['countSql'] = $this->dbConn->bindVars($this->query['countSql'], $bindVars [0], $bindVars [1], $bindVars [2]);
            }
        }
        $this->notify('NOTIFY_QUERY_BUILDER_PROCESSBINDVARS_END');
    }

    /**
     * getter
     *
     * @return mixed
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * getter
     *
     * @return mixed
     */
    public function getResultItems()
    {
        return $this->resultItems;
    }

    /**
     * getter
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * setter
     *
     * @param $value
     */
    public function setParts($value)
    {
        $this->parts = $value;
        $this->notify('NOTIFY_QUERY_BUILDER_SETPARTS_START');
    }
}
