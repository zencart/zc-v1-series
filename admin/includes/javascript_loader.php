<?php
/**
 * This file is inserted at the start of the body tag, just above the header menu, and loads most of the admin javascript components
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: neekfenwick 2023 Dec 09 Modified in v2.0.0-alpha1 $
 */
?>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="includes/javascript/jquery.min.js"><\/script>');</script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!--<script src="includes/javascript/bootstrap.min.js"></script>-->

<script src="includes/javascript/jquery-ui-i18n.min.js"></script>
<script>
// init datepicker defaults with localization
  jQuery(function () {
    jQuery.datepicker.setDefaults(jQuery.extend({}, jQuery.datepicker.regional["<?php echo $_SESSION['languages_code'] == 'en' ? '' : $_SESSION['languages_code']; ?>"], {
      dateFormat: '<?php echo DATE_FORMAT_DATE_PICKER; ?>',
      changeMonth: true,
      changeYear: true,
      showOtherMonths: true,
      selectOtherMonths: true,
      showButtonPanel: true
    }));
    jQuery('[data-toggle="tooltip"]').tooltip({
        html: true,
        container: 'body'
    });
  });
// Enable hover dropdown on desktop screens
jQuery(document).ready(function(){
    // Enable hover dropdown on desktop screens
    function enableHoverDropdown() {
        if (jQuery(window).width() > 991) {
            jQuery('.navbar .nav-item.dropdown').hover(function() {
                jQuery(this).find('.dropdown-menu').addClass('show');
            }, function() {
                jQuery(this).find('.dropdown-menu').removeClass('show');
            });
        } else {
            jQuery('.navbar .nav-item.dropdown').unbind('mouseenter mouseleave');
        }
    }

    enableHoverDropdown(); // Initial call

    // Trigger hover dropdown on window resize
    $(window).resize(function() {
        enableHoverDropdown();
    });
});
</script>
<?php
$searchBoxScriptArray = [
    'specials',
    'coupon_admin',
    'reviews',
    'featured',
    'customers',
    'category_product_listing',
    'downloads_manager',
];
$searchBoxJs = 'includes/javascript/searchBox.js';
if (in_array(basename($PHP_SELF, '.php'), $searchBoxScriptArray) && file_exists($searchBoxJs)) {
    ?>
    <script defer src="<?= $searchBoxJs; ?>"></script>
    <?php
}
?>

<?php if (file_exists($jsFile = 'includes/javascript/' . basename($PHP_SELF, '.php') . '.js')) { ?>
<script src="<?php echo $jsFile; ?>"></script>
<?php
}
if (file_exists($jsFile = 'includes/javascript/' . basename($PHP_SELF, '.php') . '.php')) {
    echo "\n";
    require 'includes/javascript/' . basename($PHP_SELF, '.php') . '.php';
}
$directory_array = $template->get_template_part('includes/javascript/', '/^' . basename($PHP_SELF, '.php') . '_/', '.js');
foreach ($directory_array as $key => $value) {
    echo "\n";
?>
<script src="includes/javascript/<?php echo $value; ?>"></script>
<?php
}
$directory_array = $template->get_template_part('includes/javascript/', '/^' . basename($PHP_SELF, '.php') . '_/', '.php');
foreach ($directory_array as $key => $value) {
    echo "\n";
    require 'includes/javascript/' . $value;
}

foreach ($installedPlugins as $plugin) {
    $relativeDir = $plugin->getRelativePath();
    $absoluteDir = $plugin->getAbsolutePath();
    $directory_array = $template->get_template_part($absoluteDir . 'admin/includes/javascript/', '/^global_jscript/', '.php');
    foreach ($directory_array as $key => $value) {
        require $absoluteDir . 'admin/includes/javascript/' . $value;
    }
    $directory_array = $template->get_template_part($absoluteDir . 'admin/includes/javascript/', '/^global_jscript/', '.js');
    foreach ($directory_array as $key => $value) {
        echo "\n";
        ?>
        <script src="<?php echo $relativeDir; ?>admin/includes/javascript/<?php echo $value; ?>"></script>
        <?php
    }
    if (file_exists($absoluteDir . 'admin/includes/javascript/' . basename($PHP_SELF, '.php') . '.php')) {
        echo "\n";
        require $absoluteDir . 'admin/includes/javascript/' . basename($PHP_SELF, '.php') . '.php';
    }
    if (file_exists($absoluteDir . 'admin/includes/javascript/' . basename($PHP_SELF, '.php') . '.js')) {
        echo "\n";
?>
        <script src="<?php echo $relativeDir ?>admin/includes/javascript/<?php echo basename($PHP_SELF, '.php') . '.js'; ?>"></script>
<?php
    }
    $directory_array = $template->get_template_part($absoluteDir . 'admin/includes/javascript/', '/^' . basename($PHP_SELF, '.php') . '_/', '.js');
    foreach ($directory_array as $key => $value) {
        echo "\n";
        ?>
        <script src="<?php echo $relativeDir; ?>admin/includes/javascript/<?php echo $value; ?>"></script>
        <?php
    }
    $directory_array = $template->get_template_part($absoluteDir . 'admin/includes/javascript/', '/^' . basename($PHP_SELF, '.php') . '_/', '.php');
    foreach ($directory_array as $key => $value) {
        echo "\n";
        require $absoluteDir . 'admin/includes/javascript/' . $value;
    }}
if (file_exists(DIR_WS_INCLUDES . 'keepalive_module.php')) {
    echo "\n";
    require(DIR_WS_INCLUDES . 'keepalive_module.php');
}
echo "\n";
require DIR_FS_CATALOG . 'includes/templates/template_default/jscript/jscript_framework.php';
