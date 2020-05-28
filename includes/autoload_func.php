<?php
/**
 * File contains the autoloader loop
 *
 * The autoloader loop takes the array from the auto_loaders directory
 * and uses this this to constuct the InitSysytem.
 * see {@link http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem} for more details.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 May 14 Modified in v1.5.7 $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

foreach ($initSystemList as $entry) {
    switch ($entry['type']) {
        case 'include':
            //echo 'case "include": ' . $entry['filePath'] . "<br>\n";
            include_once $entry['filePath'];
            break;
        case 'require':
            //echo 'case "require": ' . $entry['filePath'] . "<br>\n";
            require_once $entry['filePath'];
            break;
        case 'class':
            //echo 'case "class": ' . $entry['class'] . "<br>\n";
            $objectName = $entry['object'];
            $className = $entry['class'];
            $$objectName = new $className();
            break;
        case 'sessionClass':
            //echo 'case "sessionClass": ' . $entry['class'] . "<br>\n";
            $objectName = $entry['object'];
            $className = $entry['class'];
            if (!$entry['checkInstantiated'] || !isset($_SESSION[$objectName])) {
                $_SESSION[$objectName] = new $className();
            }
            break;
        case 'objectMethod':
            //echo 'case "objectMethod": ' . '$entry[\'method\']=' . $entry['method'] . ', $entry[\'object\']=' . $entry['object'] . "<br>\n";
            $objectName = $entry['object'];
            $methodName = $entry['method'];
              if (isset($_SESSION[$objectName]) && is_object($_SESSION[$objectName])) {
                  $_SESSION[$objectName]->$methodName();
              } else {
                  ${$objectName}->$methodName();
              }
            break;

    }
}
