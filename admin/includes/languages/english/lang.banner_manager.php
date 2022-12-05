<?php
/**
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Scott C Wilson 2022 May 05 New in v1.5.8-alpha $
*/

$define = [
    'HEADING_TITLE' => 'Banner Manager',
    'TABLE_HEADING_BANNERS' => 'Banners',
    'TABLE_HEADING_GROUPS' => 'Groups',
    'TABLE_HEADING_STATISTICS' => 'Displays / Clicks',
    'TABLE_HEADING_BANNER_OPEN_NEW_WINDOWS' => 'New Window',
    'TABLE_HEADING_BANNER_ON_SSL' => 'Show SSL',
    'TABLE_HEADING_BANNER_SORT_ORDER' => 'Sort<br>Order',
    'TEXT_BANNERS_INTRO' => 'Each Banner (text or image) is assigned to a Banner Group along with other Banners, to allow different Banners to be displayed (rotated) in the same position.<br>The position of a Banner Group on the shopfront page is defined in <a href="%s"> Configuration->Layout Settings</a>.<br>You may create a new Banner Group when creating/editing a Banner.<br>Use the Help icon <strong>?</strong> for more details.',
    'TEXT_BANNERS_TITLE' => 'Banner Title:',
    'TEXT_BANNERS_URL' => 'Banner URL:',
    'TEXT_BANNERS_GROUP' => 'Banner Group:',
    'TEXT_BANNERS_NEW_GROUP' => ', or enter a new banner group below',
    'TEXT_BANNERS_IMAGE' => 'Image:',
    'TEXT_BANNERS_IMAGE_LOCAL' => ', or enter local file below',
    'TEXT_BANNERS_IMAGE_TARGET' => 'Image Target (Save To):',
    'TEXT_BANNER_IMAGE_TARGET_INFO' => '<strong>Suggested Target location for the image on the server:</strong> ' . DIR_FS_CATALOG_IMAGES . 'banners/',
    'TEXT_BANNERS_HTML_TEXT_INFO' => '<strong>NOTE: HTML banners do not record the clicks on the banner</strong>',
    'TEXT_BANNERS_HTML_TEXT' => 'HTML Text:',
    'TEXT_BANNERS_ALL_SORT_ORDER' => 'Sort Order - banner_box_all',
    'TEXT_BANNERS_ALL_SORT_ORDER_INFO' => '<strong>NOTE: The banners_box_all sidebox will display the banners in their defined sort order</strong>',
    'TEXT_BANNERS_EXPIRES_ON' => 'Expires On: <br>(Must be after today)',
    'TEXT_BANNERS_OR_AT' => ', or at',
    'TEXT_BANNERS_IMPRESSIONS' => 'impressions/views.',
    'TEXT_BANNERS_SCHEDULED_AT' => 'Scheduled At: <br>(Must be after today)',
    'TEXT_BANNERS_BANNER_NOTE' => '<b>Banner Notes:</b><ul><li>Use an image or HTML text for the banner - not both.</li><li>HTML Text has priority over an image</li><li>HTML Text will not register the click thru, but will register displays</li><li>Banners with absolute image URLs should not be displayed on secure pages</li></ul>',
    'TEXT_BANNERS_INSERT_NOTE' => '<b>Image Notes:</b><ul><li>Uploading directories must have proper user (write) permissions setup!</li><li>Do not fill out the \'Save To\' field if you are not uploading an image to the webserver (ie, you are using a local (serverside) image).</li><li>The \'Save To\' field must be an existing directory with an ending slash (eg, banners/).</li></ul>',
    'TEXT_BANNERS_EXPIRY_NOTE' => '<b>Expiry Notes:</b><ul><li>Only one of the two fields should be submitted</li><li>If the banner is not to expire automatically, then leave these fields blank</li></ul>',
    'TEXT_BANNERS_SCHEDULE_NOTE' => '<b>Schedule Notes:</b><ul><li>If a schedule is set, the banner will be activated on that date.</li><li>All scheduled banners are marked as inactive until their date has arrived, to which they will then be marked active.</li></ul>',
    'TEXT_BANNERS_STATUS' => 'Banner Status:',
    'TEXT_BANNERS_ACTIVE' => 'Active',
    'TEXT_BANNERS_NOT_ACTIVE' => 'Not Active',
    'TEXT_INFO_BANNER_STATUS' => '<strong>NOTE:</strong> Banner status will be updated based on Scheduled Date and Impressions',
    'TEXT_BANNERS_OPEN_NEW_WINDOWS' => 'Banner New Window',
    'TEXT_INFO_BANNER_OPEN_NEW_WINDOWS' => '<strong>NOTE:</strong> Banner will open in a new window',
    'TEXT_BANNERS_ON_SSL' => 'Banner on SSL',
    'TEXT_INFO_BANNER_ON_SSL' => '<strong>NOTE:</strong> Banner can be displayed on Secure Pages without errors',
    'TEXT_BANNERS_DATE_ADDED' => 'Date Added:',
    'TEXT_BANNERS_SCHEDULED_AT_DATE' => 'Scheduled At: <b>%s</b>',
    'TEXT_BANNERS_EXPIRES_AT_DATE' => 'Expires At: <b>%s</b>',
    'TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS' => 'Expires At: <b>%s</b> impressions',
    'TEXT_BANNERS_STATUS_CHANGE' => 'Status Change: %s',
    'TEXT_BANNERS_LAST_3_DAYS' => 'Last 3 Days',
    'TEXT_INFO_DELETE_INTRO' => 'Are you sure you want to delete this banner?',
    'TEXT_INFO_DELETE_IMAGE' => 'Delete banner image',
    'SUCCESS_BANNER_INSERTED' => 'Success: The banner has been inserted.',
    'SUCCESS_BANNER_UPDATED' => 'Success: The banner has been updated.',
    'SUCCESS_BANNER_REMOVED' => 'Success: The banner has been removed.',
    'SUCCESS_BANNER_STATUS_UPDATED' => 'Success: The status of the banner has been updated.',
    'ERROR_BANNER_TITLE_REQUIRED' => 'Error: Banner title required.',
    'ERROR_BANNER_GROUP_REQUIRED' => 'Error: Banner group required.',
    'ERROR_IMAGE_DOES_NOT_EXIST' => 'Error: Image does not exist.',
    'ERROR_IMAGE_IS_NOT_WRITEABLE' => 'Error: Image can not be removed.',
    'ERROR_UNKNOWN_STATUS_FLAG' => 'Error: Unknown status flag.',
    'ERROR_BANNER_IMAGE_REQUIRED' => 'Error: Banner image required.',
    'ERROR_UNKNOWN_BANNER_OPEN_NEW_WINDOW' => 'Error: Banner could not be set to open in a new window',
    'ERROR_UNKNOWN_BANNER_ON_SSL' => 'Error: Banner could not be set to use SSL',
    'TEXT_LEGEND_BANNER_ON_SSL' => 'Show SSL',
    'TEXT_LEGEND_BANNER_OPEN_NEW_WINDOWS' => 'New Window',
    'IMAGE_ICON_BANNER_OPEN_NEW_WINDOWS_ON' => 'Open New Window - Enabled',
    'IMAGE_ICON_BANNER_OPEN_NEW_WINDOWS_OFF' => 'Open New Window - Disabled',
    'IMAGE_ICON_BANNER_ON_SSL_ON' => 'Show on Secure Pages - Enabled',
    'IMAGE_ICON_BANNER_ON_SSL_OFF' => 'Show on Secure Pages - Disabled',
    'SUCCESS_BANNER_OPEN_NEW_WINDOW_UPDATED' => 'Success: The status of the banner to open in a new window has been updated.',
    'SUCCESS_BANNER_ON_SSL_UPDATED' => 'Success: The status of the banner to show on SSL has been updated.',
];

return $define;
