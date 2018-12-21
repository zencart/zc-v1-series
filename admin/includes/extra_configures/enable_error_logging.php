<?php
/**
 * Very simple error logging to file
 *
 * Sometimes it is difficult to debug PHP background activities, especially when most information cannot be safely output to the screen.
 * However, using the PHP error logging facility we can store all PHP errors to a file, and then review separately.
 * Using this method, the debug details are stored at: /logs/myDEBUG-adm-999999-00000000.log
 * Credits to @lat9 for adding backtrace functionality
 *
 * @package debug
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: lat9 Sun Feb 25 13:35:20 2018 -0500 Modified in v1.5.6 $
 */
require DIR_FS_CATALOG . 'includes/extra_configures/enable_error_logging.php';