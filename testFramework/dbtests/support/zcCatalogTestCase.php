<?php
/**
 * File contains framework test cases
 *
 * @package tests
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id$
 */

require_once('zcTestCase.php');

if (!defined('IS_ADMIN_FLAG')) {
    define('IS_ADMIN_FLAG', false);
}

/**
 * Testing Library
 */
abstract class zcCatalogTestCase extends zcTestCase
{
}
