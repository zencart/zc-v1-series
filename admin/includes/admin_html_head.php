<?php
/**
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 May 20 New in v1.5.7 $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
?>
<meta charset="<?php echo CHARSET; ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo TITLE; ?></title>
<?php if (file_exists($file = 'includes/css/bootstrap.min.css')) { ?>
    <link rel="stylesheet" href="<?php echo $file; ?>">
<?php } else { ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<?php } ?>
<?php if (file_exists($file = 'includes/css/font-awesome.min.css')) { ?>
    <link rel="stylesheet" href="<?php echo $file; ?>">
<?php } else { ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<?php } ?>
<?php if (file_exists($file = 'includes/css/jquery-ui.css')) { ?>
    <link rel="stylesheet" href="<?php echo $file; ?>">
<?php } else { ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php } ?>
    <link rel="stylesheet" href="includes/css/jAlert.css">
    <link rel="stylesheet" href="includes/css/menu.css">
    <link rel="stylesheet" href="includes/css/stylesheet.css">
<?php if (file_exists($file = 'includes/css/' . basename($PHP_SELF, '.php') . '.css')) { ?>
    <link rel="stylesheet" href="<?php echo $file; ?>">
<?php } ?>
<?php
// pull in any necessary JS for the page
require(DIR_WS_INCLUDES . 'javascript_loader.php');
