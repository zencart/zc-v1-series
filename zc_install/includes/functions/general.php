<?php
/**
 * general functions
 *
 * @package functions
 * @copyright Copyright 2003-2013 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id:
 */

if (!defined('TABLE_UPGRADE_EXCEPTIONS')) define('TABLE_UPGRADE_EXCEPTIONS','upgrade_exceptions');

function zen_get_select_options($optionList, $setDefault)
{
  $optionString = "";
  foreach ($optionList as $option)
  {
    $optionString .= '<option value="' . $option['id'] . '"';
    if ($setDefault == $option['id']) $optionString .= " SELECTED ";
    $optionString .= '>' . $option['text'];
    $optionString .='</option>';
  }
  return $optionString;
}
  function zen_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }
  
  function logDetails($details, $location = "General") {
      if ($_SESSION['logfilename'] == '') $_SESSION['logfilename'] = date('M-d-Y_h-i-s-') . zen_create_random_value(6);
      if ($fp = @fopen(DIR_FS_ROOT . 'logs/zcInstallLog_' . $_SESSION['logfilename'] . '.log', 'a')) {
        fwrite($fp, '---------------' . "\n" . date('M d Y G:i') . ' -- ' . $location . "\n" . $details . "\n\n");
        fclose($fp);
      }
    }

   function zen_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }
  function zen_get_document_root() {
    $dir_fs_www_root = realpath(dirname(basename(__FILE__)) . "/..");
    if ($dir_fs_www_root == '') $dir_fs_www_root = '/';
    $dir_fs_www_root = str_replace(array('\\','//'), '/', $dir_fs_www_root);
    return $dir_fs_www_root;
  }
  function zen_get_http_server()
  {
    return $_SERVER['HTTP_HOST'];
  }
  function zen_sanitize_request()
  {
    if (isset($_POST) && count($_POST) > 0) 
    {
      foreach($_POST as $key=>$value)
      {
        if(is_array($value))
        {
          foreach($value as $key2 => $val2)
          {
            unset($GLOBALS[$key]);
          }
        } else {
          unset($GLOBALS[$key]);
        }
      }
    }
  	$ignoreArray = array();
  	foreach ($_POST as $key => $value)
  	{
  		$_POST[htmlspecialchars($key, ENT_COMPAT, 'UTF-8', FALSE)] = addslashes($value);
  	}
  }
  /**
   * Returns a string with conversions for security.
   * @param string The string to be parsed
   * @param string contains a string to be translated, otherwise just quote is translated
   * @param boolean Do we run htmlspecialchars over the string
   */
  function zen_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string, ENT_COMPAT, 'utf-8', TRUE);
    } else {
      if ($translate == false) {
        return zen_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return zen_parse_input_field_data($string, $translate);
      }
    }
  }
  
  /**
   * Returns a string with conversions for security.
   *
   * Simply calls the zen_ouput_string function
   * with parameters that run htmlspecialchars over the string
   * and converts quotes to html entities
   *
   * @param string The string to be parsed
   */
  function zen_output_string_protected($string) {
    return zen_output_string($string, false, true);
  }
  
  