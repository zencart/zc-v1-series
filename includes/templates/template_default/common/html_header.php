<?php
/**
 * Common Template
 *
 * outputs the html header, eg the doctype and the entire [HEAD] section
 *
 * @package templateSystem
 * @copyright Copyright 2003-2013 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Tue Jul 17 16:02:00 2012 -0400 Modified in v1.5.1 $
 */

/**
 * output main page HEAD tag and related headers etc
 */
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php echo HTML_PARAMS; ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php echo HTML_PARAMS; ?>> <!--<![endif]-->
  <head>
    <meta charset="<?php echo CHARSET; ?>">
    <title><?php echo META_TAG_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?php echo STORE_NAME ?>">
    <meta name="generator" content="shopping cart program by Zen Cart(R), http://www.zen-cart.com eCommerce software">
    <meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>">
    <meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>">
<?php if ($robotsNoIndex === true) { ?>
    <meta name="robots" content="noindex, nofollow"<?php if ($isRobotsMaintenanceMode) echo ' mode="maintenance"'; ?>>
<?php } ?>

    <base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>">
<?php if (isset($canonicalLink) && $canonicalLink != '') { ?>
    <link rel="canonical" href="<?php echo $canonicalLink; ?>">
<?php } ?>

<?php
  // output assembled stylesheet links (see modules/tpl_css_js_generator.php)
  echo $template_css_output;
  echo "\n";

  // run dynamically-generated jscript_XXXXX.php files
  foreach ($jscriptsTop as $val) {
    require($page_directory . '/' . $val); echo "\n";
  }

  // output src links to scripts
  echo $template_js_output_top;
?>
    <!--[if lt IE 9]>
    <meta http-equiv="imagetoolbar" content="no">
    <![endif]-->
<?php
  // FAVICON markup called from template:
  require($template->get_template_dir('tpl_favicon.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_favicon.php');
?>

  </head>

<?php
  // DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';
?>

