<?php
/**
 * @package admin
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version  $Id: New in v1.6.0 $
 */

if (!defined('IS_ADMIN_FLAG')) die('Illegal Access');

define('SUPERUSER_PROFILE', 1);

$val = getenv('HABITAT');
$habitat = ($val == 'zencart' || (isset($_SERVER['USER']) && $_SERVER['USER'] == 'vagrant'));

// admin folder rename required
if ((!defined('ADMIN_BLOCK_WARNING_OVERRIDE') || ADMIN_BLOCK_WARNING_OVERRIDE == '') && ($habitat == false))
{
  if (basename($_SERVER['SCRIPT_FILENAME']) != FILENAME_ALERT_PAGE . '.php')
  {
    if (substr(DIR_WS_ADMIN, -7) == '/admin/' || substr(DIR_WS_HTTPS_ADMIN, -7) == '/admin/')
    {
      header("Status: 403 Forbidden", TRUE, 403);
      echo json_encode(array('error'=>TRUE, 'errorType'=>"ADMIN_BLOCK_WARNING"));
      exit(1);
    }
    $check_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/../zc_install';
    if (is_dir($check_path))
    {
      header("Status: 403 Forbidden", TRUE, 403);
      echo json_encode(array('error'=>TRUE, 'errorType'=>"ADMIN_BLOCK_WARNING"));
      exit(1);
    }
  }
}
if (!isset($_SESSION['admin_id']))
{
  header("Status: 403 Forbidden", TRUE, 403);
  echo json_encode(array('error'=>TRUE, 'errorType'=>"AUTH_ERROR"));
  exit(1);
}
