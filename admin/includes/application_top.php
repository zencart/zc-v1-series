<?php
/**
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: mc12345678 2019 Oct 09 Modified in v1.5.7 $
 */
/**
 * File contains just application_top code
 *
 * Initializes common classes & methods. Controlled by an array which describes
 * the elements to be initialised and the order in which that happens.
 *
 */
require_once('includes/application_bootstrap.php');
/**
 * Prepare init-system
 */

use Zencart\InitSystem\InitSystem;
use Zencart\FileSystem\FileSystem;

$autoLoadConfig = array();
if (isset($loaderPrefix)) {
  $loaderPrefix = preg_replace('/[^a-z_]/', '', $loaderPrefix);
} else {
  $loaderPrefix = 'config';
}
$loader_file = $loaderPrefix . '.core.php';
$initSystem = new InitSystem('admin', $loaderPrefix, FileSystem::getInstance(), $pluginManager, $installedPlugins);
$loaderList = $initSystem->loadAutoLoaders();
$initSystemList = $initSystem->processLoaderList($loaderList);

require(DIR_FS_CATALOG . 'includes/autoload_func.php');

