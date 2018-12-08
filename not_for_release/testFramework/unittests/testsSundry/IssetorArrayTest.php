<?php
/**
 * @package tests
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Zcwilt Sat Oct 20 21:10:01 2018 +0100 New in v1.5.6 $
 */
require_once(__DIR__ . '/../support/zcTestCase.php');

/**
 * Unit Tests for password hashing rules
 */
class testIssetorArray extends zcTestCase
{
    public function setup()
    {
        parent::setup();
        require_once DIR_FS_CATALOG . 'includes/functions/functions_general.php';
    }

    public function testIssetor()
    {
        $somearray = [];
        $result = issetorArray($somearray, 'key', 'default');
        $this->assertTrue($result == 'default');
        $somearray = array('key' => 'notdefault');
        $result = issetorArray($somearray, 'key', 'default');
        $this->assertTrue($result == 'notdefault');
    }
}
