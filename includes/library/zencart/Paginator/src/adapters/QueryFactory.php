<?php
/**
 * Class QueryFactory
 *
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: $
 */
namespace ZenCart\Paginator\adapters;

use ZenCart\Paginator\AdapterInterface;
use ZenCart\Paginator\AbstractAdapter;

/**
 * Class QueryFactory
 * @package ZenCart\Paginator\adapters
 */
class QueryFactory extends AbstractAdapter implements AdapterInterface
{

    /**
     * @param $data
     * @param array $params
     * @return array
     */
    public function getResultList($data, array $params)
    {
//        print_r($data['mainSql']);
        $limit = $params['currentItem'] - 1 . ',' . $params['itemsPerPage'];
        $results = $data['dbConn']->execute($data['mainSql'], $limit);
        $resultList = array();
        foreach ($results as $result) {
            $resultList[] = $result;
        }
        return $resultList;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getTotalItemCount($data)
    {
        $result = $data['dbConn']->execute($data['countSql']);
        return $result->fields['total'];
    }
} 
