<?php
/**
 * Module Template
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id:  Modified in v2.0.0-alpha $
 */
require DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE);
?>

<!-- Modal HTML -->
<div id="imageModalPrimary" class="imgmodal">
    <div class="imgmodal-content">
        <span onclick="closeModal('imageModalPrimary')">
        <?php echo zen_image($products_image_medium, $products_name, '', '', 'class="centered-image"'); ?>
<!--        <div class="imgLink center">--><?php //echo TEXT_CLOSE_WINDOW_IMAGE; ?><!--</div>-->
        </span>
    </div>
</div>
<div id="productMainImage" class="centeredContent back">
    <a href="javascript:void(0);" onclick="openModal('imageModalPrimary')">
        <?php echo zen_image($products_image_medium, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT); ?>
        <br>
<!--        <div class="imgLink center">--><?php //echo TEXT_CLICK_TO_ENLARGE; ?><!--</div>-->
    </a>
</div>
