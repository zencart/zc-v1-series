<?php
/**
 * @package tests
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: $
 */

define('SERVER_NAME', 'localhost');
define('BASE_URL', 'localhost:4445');
define('DB_HOST', 'localhost');
define('DB_USER', 'travis');
define('DB_PASS', '');
define('DB_DBNAME', 'zencart');
define('DB_PREFIX', '');
define('DIR_FS_ROOT', CWD);
define('DIR_ADMIN', 'admin');
define('DIR_WS_ADMIN', BASE_URL . DIR_ADMIN . '/');
define('DIR_FS_ADMIN', DIR_FS_ROOT. DIR_ADMIN . '/');
define('DIR_FS_CATALOG', DIR_FS_ROOT);
define('DO_SCREENSHOT', FALSE);
define('SCREENSHOT_PATH', DIR_FS_CATALOG);

define('WEBTEST_STORE_NAME', 'Selenium Test Store on ' . BASE_URL);
define('WEBTEST_STORE_OWNER', 'Selenium Test ' . BASE_URL);
define('WEBTEST_STORE_OWNER_EMAIL', 'noreply@' . SERVER_NAME);
define('WEBTEST_ADMIN_EMAIL', 'noreply@'. SERVER_NAME);

define('WEBTEST_DEFAULT_CUSTOMER_EMAIL', 'test1@'. SERVER_NAME);
define('WEBTEST_DEFAULT_CUSTOMER_PASSWORD', 'password');
define('WEBTEST_UK_CUSTOMER_EMAIL', 'testuk@'. SERVER_NAME);
define('WEBTEST_UK_CUSTOMER_PASSWORD', 'password');
define('WEBTEST_CANADA_CUSTOMER_EMAIL', 'testcanada@'. SERVER_NAME);
define('WEBTEST_CANADA_CUSTOMER_PASSWORD', 'password');

define('WEBTEST_ADMIN_NAME_INSTALL', 'Admin');
define('WEBTEST_ADMIN_PASSWORD_INSTALL', 'adminPassTemp99');
define('WEBTEST_ADMIN_PASSWORD_INSTALL_1', 'adminPass99');
define('WEBTEST_ADMIN_PASSWORD_INSTALL_SSL', 'adminPass909');

define('WEBTEST_USE_SMTP', false);
define('WEBTEST_EMAIL_SMTPAUTH_MAILBOX', '');
define('WEBTEST_EMAIL_SMTPAUTH_MAIL_SERVER', '');
define('WEBTEST_EMAIL_SMTPAUTH_PASSWORD', '');
define('WEBTEST_EMAIL_SMTPAUTH_MAIL_SERVER_PORT', '');
define('WEBTEST_EMAIL_LINEFEED', 'CRLF');
