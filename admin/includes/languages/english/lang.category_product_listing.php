<?php
/**
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Steve 2024 May 31 Modified in v2.1.0-alpha1 $
*/

$define = [
    'HEADING_TITLE' => 'Categories / Products',
    'HEADING_TITLE_GOTO' => 'Go To:',
    'TABLE_HEADING_IMAGE' => 'Image',
    'TABLE_HEADING_CATEGORIES_PRODUCTS' => 'Categories / Products',
    'TABLE_HEADING_QUANTITY' => 'Quantity',
    'TABLE_HEADING_CATEGORIES_SORT_ORDER' => 'Sort',
    'TEXT_PRODUCTS_STATUS_ON_OF' => ' of ',
    'TEXT_PRODUCTS_STATUS_ACTIVE' => ' active ',
    'TEXT_CATEGORIES' => 'Categories:',
    'TEXT_PRODUCTS' => 'Products:',
    'TEXT_INFO_HEADING_DELETE_CATEGORY' => 'Delete Category',
    'TEXT_DELETE_CATEGORY_INTRO' => 'Are you sure you want to delete this category?',
    'TEXT_DELETE_CATEGORY_INTRO_LINKED_PRODUCTS' => '<strong>Warning:</strong> Linked Products whose Master Categories ID are deleted will not price properly. You should first assure that when deleting a Category that contains Linked Products that you reset the Product(s) Master Categories ID to another Category before removing a Category',
    'TEXT_DELETE_WARNING_CHILDS' => '<b>WARNING:</b> There are %u subcategories still under this category!',
    'TEXT_DELETE_WARNING_PRODUCTS' => '<b>WARNING:</b> There are %u products still under this category!',
    'TEXT_INFO_HEADING_MOVE_CATEGORY' => 'Move Category',
    'TEXT_MOVE_CATEGORIES_INTRO' => 'Please select which category you wish <b>%s</b> to reside in',
    'TEXT_MOVE_PRODUCT' => 'Move product<br><strong>ID#%1$u %2$s</strong><br>from current category<br><strong>ID#%3$u %4$s</strong><br>to:',
    'TEXT_INFO_HEADING_DELETE_PRODUCT' => 'Delete Product/Links',
    'TEXT_DELETE_PRODUCT_INTRO' => 'Delete this product\'s links to categories or delete the product completely.<br>For easier linking/unlinking of products to multiple categories, you may also use the <a href="index.php?cmd=' . FILENAME_PRODUCTS_TO_CATEGORIES . '&amp;products_filter=%u">Multiple Categories Link Manager</a>.<br><br><strong>Linked categories</strong> are pre-selected ready for deletion.<br>The <strong>Master Category</strong> (<span class="text-danger">highlighted</span>) is de-selected to prevent accidental deletion.<br><br>To delete a product completely, select ALL categories including the Master Category.',
    'TEXT_INFO_HEADING_MOVE_PRODUCT' => 'Move Product',
    'TEXT_MOVE_PRODUCTS_INTRO' => 'Move this product from this category to the selected category.<br>If this current category is also the product\'s Master Category, that will also be updated to the selected category.<br>',
    'TEXT_INFO_CURRENT_CATEGORIES' => 'Current Categories: ',
    'TEXT_INFO_HEADING_COPY_TO' => 'Copy To',
    'TEXT_INFO_CURRENT_PRODUCT' => 'Current Product: ',
    'TEXT_HOW_TO_COPY' => 'Copy Method:',
    'TEXT_COPY_AS_LINK' => 'Link this product into another category as selected above',
    'TEXT_COPY_AS_DUPLICATE' => 'Create a Duplicate product in the category selected above',
    'TEXT_COPY_METATAGS' => 'Copy Metatags to Duplicate?',
    'TEXT_COPY_LINKED_CATEGORIES' => 'Copy Linked Categories to Duplicate?',
    'TEXT_COPY_EDIT_DUPLICATE' => 'Open Duplicate Product for editing',
    'TEXT_COPY_AS_DUPLICATE_ATTRIBUTES' => 'Attributes copied from Product ID#%1$u to duplicate Product ID#%2$u',
    'TEXT_COPY_AS_DUPLICATE_METATAGS' => 'Metatags for Language ID#%1$u copied from Product ID#%2$u to duplicate Product ID#%3$u',
    'TEXT_COPY_AS_DUPLICATE_CATEGORIES' => 'Linked Category ID#%1$u copied from Product ID#%2$u to duplicate Product ID#%3$u',
    'TEXT_COPY_AS_DUPLICATE_DISCOUNTS' => 'Discounts copied from Product ID#%1$u to duplicate Product ID#%2$u',
    'TEXT_COPY_AS_DUPLICATE_SPECIALS' => 'Special Pricing copied from Product ID#%1$u to duplicate Product ID#%2$u',
    'TEXT_DUPLICATE_IDENTIFIER' => 'COPY',
    'TEXT_INFO_HEADING_ATTRIBUTE_FEATURES' => 'Attributes Changes for Products ID# ',
    'TEXT_PRODUCTS_ATTRIBUTES_INFO' => 'Attribute Features For:',
    'TEXT_PRODUCT_ATTRIBUTES_DOWNLOADS' => 'Downloads: ',
    'TEXT_INFO_ATTRIBUTES_FEATURES_DELETE' => 'Delete <strong>ALL</strong> Product Attributes for:<br>',
    'TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_PRODUCT' => 'Copy Attributes to another <strong>product</strong> from:<br>',
    'TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_CATEGORY' => 'Copy Attributes to another <strong>category</strong> from:<br>',
    'TEXT_COPY_ATTRIBUTES' => 'Copy Product Attributes to Duplicate?',
    'TEXT_COPY_SPECIALS' => 'Copy Product Specials Price to Duplicate?',
    'TEXT_COPY_DISCOUNTS_ONLY' => 'Only used for Duplicate Products with Quantity Discounts ...',
    'TEXT_COPY_DISCOUNTS' => 'Copy Product Quantity Discounts to Duplicate?',
    'TEXT_INFO_HEADING_STATUS_CATEGORY' => 'Change Category Status for:',
    'TEXT_CATEGORIES_STATUS_INTRO' => 'Change <strong>this</strong> category\'s status to: ',
    'TEXT_CATEGORIES_STATUS_OFF' => 'Disabled',
    'TEXT_CATEGORIES_STATUS_ON' => 'Enabled',
    'TEXT_PRODUCTS_STATUS_INFO' => 'Change ALL included products status to:',
    'TEXT_PRODUCTS_STATUS_OFF' => 'Disabled',
    'TEXT_PRODUCTS_STATUS_ON' => 'Enabled',
    'TEXT_PRODUCTS_STATUS_NOCHANGE' => 'Unchanged',
    'TEXT_CATEGORIES_STATUS_WARNING' => '<strong>WARNING ...</strong><br>Note: Disabling products (whether they are linked or master products) in a category will result in ALL instances of that product being disabled in ALL categories.',
    'TEXT_SUBCATEGORIES_STATUS_INFO' => 'Change ALL subcategories status to:',
    'TEXT_SUBCATEGORIES_STATUS_OFF' => 'Disabled',
    'TEXT_SUBCATEGORIES_STATUS_ON' => 'Enabled',
    'TEXT_SUBCATEGORIES_STATUS_NOCHANGE' => 'Unchanged',
    'WARNING_PRODUCTS_IN_TOP_INFO' => 'WARNING: You have Products in the Top Level Category. This will cause pricing to not work properly in the Catalog. Products found: ',
    'TEXT_COPY_MEDIA_MANAGER' => 'Copy media?',
    'SUCCESS_ATTRIBUTES_DELETED' => 'Attributes successfully deleted',
    'TEXT_SORT_CATEGORIES_NAME_DESC' => 'Category Name (desc)',
    'TEXT_SORT_CATEGORIES_ID' => 'Category ID',
    'TEXT_SORT_CATEGORIES_ID_DESC' => 'Category ID (desc)',
    'TEXT_SORT_CATEGORIES_STATUS' => 'Category Status (disabled)',
    'TEXT_SORT_CATEGORIES_STATUS_DESC' => 'Category Status (enabled)',
    'TEXT_SORT_PRODUCTS_MODEL_DESC' => 'Products Model (desc)',
    'TEXT_SORT_PRODUCTS_STATUS' => 'Status (disabled), Name',
    'TEXT_SORT_PRODUCTS_STATUS_DESC' => 'Status (enabled), Name',
    'TEXT_SORT_PRODUCTS_ID' => 'Products ID',
    'TEXT_SORT_PRODUCTS_ID_DESC' => 'Products ID (desc)',
    'TEXT_SORT_PRODUCTS_WEIGHT' => 'Weight',
    'TEXT_HIDE_IMAGES' => 'Hide Images',
    'TEXT_SHOW_IMAGES' => 'Show Images',
];

return $define;
