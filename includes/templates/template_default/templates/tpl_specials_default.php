<?php
/**
 * Page Template
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2024 Jan 31 Modified in v2.0.0-beta1 $
 */
?>
<div class="centerColumn" id="specialsListing">

<h1 id="specialsListingHeading"><?php echo HEADING_TITLE; ?>
<?php if (!empty($_GET['sale_category'])) {
    echo ' : ' . zen_get_category_name((int)$_GET['sale_category']);
}
?>
</h1>

<div id="filter-wrapper" class="group">
<?php
/**
 * display the product sort dropdown
 */
require $template->get_template_dir('/tpl_modules_listing_display_order.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_listing_display_order.php';
?>
</div>

<?php
require $template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php';
?>

</div>
