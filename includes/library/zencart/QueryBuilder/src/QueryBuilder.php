<?php
/**
 * Class QueryBuilder
 *
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: New in v1.6.0 $
 */
namespace ZenCart\QueryBuilder;

/**
 * Class QueryBuilder
 * @package ZenCart\QueryBuilder
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
     * @param array $listingQuery
     */
    public function __construct($dbConn, array $listingQuery = array())
    {
        $this->dbConn = $dbConn;
        $this->parts = null;
        if (count($listingQuery) > 0) {
            $this->initParts($listingQuery);
        }
    }
    public function initParts(array $listingQuery)
    {
        $this->notify('NOTIFY_QUERYBUILDER_INIT_START');
        $this->parts ['bindVars'] = issetorArray($listingQuery, 'bindVars', array());
        $this->parts ['selectList'] = issetorArray($listingQuery, 'selectList', array());
        $this->parts ['orderBys'] = issetorArray($listingQuery, 'orderBys', array());
        $this->parts ['groupBys'] = issetorArray($listingQuery, 'groupBys', array());
        $this->parts ['filters'] = issetorArray($listingQuery, 'filters', array());
        $this->parts ['derivedItems'] = issetorArray($listingQuery, 'derivedItems', array());
        $this->parts ['joinTables'] = issetorArray($listingQuery, 'joinTables', array());
        $this->parts ['whereClauses'] = issetorArray($listingQuery, 'whereClauses', array());
        $this->parts ['mainTableName'] = TABLE_PRODUCTS;
        $this->parts ['mainTableAlias'] = 'p';
        $this->parts ['mainTableFkeyField'] = 'products_id';
        if (isset($listingQuery['mainTable'])) {
            $this->parts ['mainTableName'] = $listingQuery['mainTable'] ['table'];
            $this->parts ['mainTableAlias'] = $listingQuery['mainTable'] ['alias'];
            $this->parts ['mainTableFkeyField'] = $listingQuery['mainTable'] ['fkeyFieldLeft'];
        }
        $this->parts ['tableAliases'] [$this->parts ['mainTableName']] = $this->parts ['mainTableAlias'];
        $this->notify('NOTIFY_QUERYBUILDER_INIT_END');
    }

    /**
     * process query
     *
     */
    public function processQuery($listingQuery)
    {
        if (!isset($this->parts)) {
            $this->initParts($listingQuery);
        }
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSQUERY_START');
        $this->query ['select'] = "SELECT " . (issetorArray($listingQuery, 'isDistinct', false) ? ' DISTINCT ' : '') . $this->parts ['mainTableAlias'] . ".*";
        $this->preProcessJoins();
        $this->query ['joins'] = '';
        $this->query ['table'] = ' FROM ';
        $this->processJoins();
        $this->query ['table'] .= $this->parts ['mainTableName'] . " AS " . $this->parts ['mainTableAlias'] . " ";
        $this->processWhereClause();
        $this->processOrderBys();
        $this->processGroupBys();
        $this->processSelectList();
        $this->setFinalQuery($listingQuery);
        $this->processBindVars();
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSQUERY_END');
    }

    protected function setFinalQuery($listingQuery)
    {
        $this->notify('NOTIFY_QUERYBUILDER_SETFINALQUERY_START');
        $this->query['mainSql'] = $this->query ['select'] . $this->query ['table'] .
            $this->query ['joins'] . $this->query ['where'] . $this->query ['orderBy'] . $this->query ['groupBy'];
        if (!isset($this->query['countSql'])) {
            $this->query['countSql'] = "SELECT COUNT(" . (issetorArray($listingQuery, 'isDistinct', false) ? "DISTINCT " : '') .
                $this->parts ['mainTableAlias'] . "." . $this->parts ['mainTableFkeyField'] . ")
                                 AS total " . $this->query ['table'] . $this->query ['joins'] .
                $this->query ['where'];;
        }
        $this->notify('NOTIFY_QUERYBUILDER_SETFINALQUERY_END');
    }
    /**
     * preprocess joins
     *
     */
    protected function preProcessJoins()
    {
        $this->notify('NOTIFY_QUERYBUILDER_PREPROCESSJOINS_START');
        if (count($this->parts ['joinTables']) == 0) {
            return;
        }
        foreach ($this->parts ['joinTables'] as $joinTable) {
            $this->parts ['tableAliases'] [$joinTable ['table']] = $joinTable ['alias'];
        }
        $this->query ['joins'] = '';
        $this->notify('NOTIFY_QUERYBUILDER_PREPROCESSJOINS_END');
    }

    /**
     * process joins
     *
     */
    protected function processJoins()
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINS_START');
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
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINS_END');
    }

    /**
     * process join custom adds
     *
     * @param $joinTable
     */
    protected function processJoinCustomAnd($joinTable)
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINSCUSTOMAND_START');
        if (isset($joinTable ['customAnd'])) {
            $this->query ['joins'] .= " " . $joinTable ['customAnd'] . " ";
        }
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINSCUSTOMAND_END');
    }

    /**
     * process join add columns
     *
     * @param $joinTable
     */
    protected function processJoinAddColumns($joinTable)
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINADDCOLUMN_START');
        if (isset($joinTable ['addColumns']) && $joinTable ['addColumns']) {
            $this->query ['select'] .= ", " . $joinTable ['alias'] . ".*";
        }
        if (isset($joinTable ['selectColumns'])) {
            foreach ($joinTable ['selectColumns'] as $column)
            $this->query ['select'] .= ", " . $joinTable ['alias'] . "." . $column;
        }
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINADDCOLUMN_ENDT');
    }

    /**
     * process join foreign keys
     *
     * @param $joinTable
     */
    protected function processJoinFkeyField($joinTable)
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINFKEYFIELD_START');
        $fkeyFieldLeft = $this->parts ['mainTableAlias'] . '.' . $this->parts ['mainTableFkeyField'];
        $fkeyFieldRight = $joinTable ['alias'] . '.' . $this->parts ['mainTableFkeyField'];
        if (!isset($joinTable ['fkeyFieldLeft'])) {
            $this->query ['joins'] .= " ON " . $fkeyFieldLeft . " = " . $fkeyFieldRight . " ";
            return;

        }
        $fkeyFieldLeft = $this->parts ['mainTableAlias'] . '.' . $joinTable ['fkeyFieldLeft'];
        if (isset($joinTable ['fkeyTable'])) {
           // print_r($this->parts);
            $fkeyFieldLeft = $this->parts ['tableAliases'] [constant($joinTable ['fkeyTable'])] . '.' . $joinTable ['fkeyFieldLeft'];
        }
        $fkeyFieldRight = $joinTable ['alias'] . '.' . $joinTable ['fkeyFieldLeft'];
        if (isset($joinTable ['fkeyFieldRight'])) {
            $fkeyFieldRight = $joinTable ['alias'] . '.' . $joinTable ['fkeyFieldRight'];
        }
        $this->query ['joins'] .= " ON " . $fkeyFieldLeft . " = " . $fkeyFieldRight . " ";
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSJOINFKEYFIELD_END');
    }

    /**
     * process where clauses
     */
    protected function processWhereClause()
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSWHERECLAUSE_START');
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
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSWHERECLAUSE_END');
    }

    /**
     * process where clauses test
     *
     * @param $whereClause
     */
    protected function processWhereClauseTest($whereClause)
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSWHERECLAUSETEST_START');
        if (!isset($whereClause ['test'])) {
            $whereClause ['test'] = '=';
        }
        $default = ' ' . $whereClause ['test'] . ' ' . $whereClause ['value'];
        $hashMap = array('IN' => " IN ( " . $whereClause ['value'] . " ) ",
                         'LIKE' => " LIKE " . $whereClause ['value'] . " ");

        $addTest = (isset($hashMap[strtoupper($whereClause ['test'])])) ? $hashMap[strtoupper($whereClause ['test'])] : $default;
        $this->query['where'] .= " " . $whereClause ['type'] . " " . $this->parts ['tableAliases'] [$whereClause ['table']] . "." . $whereClause ['field'] . $addTest;
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSWHERECLAUSETEST_END');
    }

    /**
     * process orderBy clauses
     */
    protected function processOrderBys()
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSORDERBYS_START');
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
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSORDERBYS_END');
    }

    /**
     * process orderBy clauses
     */
    protected function processGroupBys()
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSGROUPBYS_START');
        $this->query ['groupBy'] = "";
        if (count($this->parts ['groupBys']) == 0) {
            return;
        }
        $this->query ['groupBy'] = " GROUP BY ";
        foreach ($this->parts ['groupBys'] as $groupBy) {
            $result = $this->processGroupByEntry($groupBy);
            if ($result) {
                continue;
            }
        }
        if (substr($this->query ['groupBy'], strlen($this->query ['groupBy']) - 2) == ', ') {
            $this->query ['groupBy'] = substr($this->query ['groupBy'], 0, strlen($this->query ['groupBy']) - 2) . " ";
        }
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSGROUPBYS_END');
    }

    protected function processGroupByEntry($groupBy)
    {
        $this->query ['groupBy'] .= $groupBy . ", ";
        return false;
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
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSSELECTLIST_START');
        if (count($this->parts ['selectList']) == 0) {
            return;
        }
        foreach ($this->parts ['selectList'] as $selectList) {
            $this->query ['select'] .= ", " . $selectList;
        }
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSSELECTLIST_END');
    }

    /**
     * process bindVars clauses
     */
    protected function processBindVars()
    {
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSBINDVARS_START');
        if (count($this->parts ['bindVars']) == 0) {
            return;
        }
        foreach ($this->parts ['bindVars'] as $bindVars) {
            $this->query['mainSql'] = $this->dbConn->bindVars($this->query['mainSql'], $bindVars [0], $bindVars [1], $bindVars [2]);
            if (isset($this->query['countSql'])) {
                $this->query['countSql'] = $this->dbConn->bindVars($this->query['countSql'], $bindVars [0], $bindVars [1], $bindVars [2]);
            }
        }
        $this->notify('NOTIFY_QUERYBUILDER_PROCESSBINDVARS_END');
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
        $this->notify('NOTIFY_QUERYBUILDER_SETPARTS_START');
    }
}
