<?php
/**
 * product-specials functions
 *
 * @package functions
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: specials.php 18695 2011-05-04 05:24:19Z drbyte $
 */

////
// Set the status of a product on special
  function zen_set_specials_status($specials_id, $status) {
    global $db, $zco_notifier;
    $sql = "update " . TABLE_SPECIALS . "
            set status = '" . (int)$status . "', date_status_change = now()
            where specials_id = '" . (int)$specials_id . "'";

    $zco_notifier->notify('NOTIFY_TOGGLE_SPECIALS_STATUS', $specials_id, $status);
    return $db->Execute($sql);
   }

////
// Auto expire products on special
  function zen_expire_specials() {
    global $db, $zco_notifier;

    $date_range = time();
    $zc_specials_date = date('Ymd', $date_range);

    $specials_query = "select specials_id, products_id
                       from " . TABLE_SPECIALS . "
                       where status = '1'
                       and ((:zc_specials_date: >= expires_date and expires_date != '0001-01-01')
                       or (:zc_specials_date: < specials_date_available and specials_date_available != '0001-01-01'))";
    
    $specials_query = $db->bindVars($specials_query, ':zc_specials_date:', $zc_specials_date, 'date');

    $specials = $db->Execute($specials_query);

    if ($specials->RecordCount() > 0) {
      foreach ($specials as $specials_item) {
        zen_set_specials_status($specials_item['specials_id'], '0');
        zen_update_products_price_sorter($specials_item['products_id']);
        $zco_notifier->notify('NOTIFY_EXPIRE_SPECIALS', $specials_item);
      }
    }
  }

////
// Auto start products on special
  function zen_start_specials() {
    global $db, $zco_notifier;

    $date_range = time();
    $zc_specials_date = date('Ymd', $date_range);

// turn on special if active
    $specials_query = "select specials_id, products_id
                       from " . TABLE_SPECIALS . "
                       where status = '0'
                       and (((specials_date_available <= :zc_specials_date: and specials_date_available != '0001-01-01') and (expires_date > :zc_specials_date:))
                       or ((specials_date_available <= :zc_specials_date: and specials_date_available != '0001-01-01') and (expires_date = '0001-01-01'))
                       or (specials_date_available = '0001-01-01' and expires_date > :zc_specials_date:))
                       ";
                       
    $specials_query = $db->bindVars($specials_query, ':zc_specials_date:', $zc_specials_date, 'date');

    $specials = $db->Execute($specials_query);

    if ($specials->RecordCount() > 0) {
      foreach ($specials as $specials_item) {
        zen_set_specials_status($specials_item['specials_id'], '1');
        zen_update_products_price_sorter($specials_item['products_id']);
        $zco_notifier->notify('NOTIFY_START_SPECIALS_ON', $specials_item);
      }
    }

// turn off special if not active yet
    $specials_query = "select specials_id, products_id
                       from " . TABLE_SPECIALS . "
                       where status = '1'
                       and (:zc_specials_date: < specials_date_available and specials_date_available != '0001-01-01')
                       ";
                       
    $specials_query = $db->bindVars($specials_query, ':zc_specials_date:', $zc_specials_date, 'date');

    $specials = $db->Execute($specials_query);

    if ($specials->RecordCount() > 0) {
      foreach ($specials as $specials_item) {
        zen_set_specials_status($specials_item['specials_id'], '0');
        zen_update_products_price_sorter($specials_item['products_id']);
        $zco_notifier->notify('NOTIFY_START_SPECIALS_OFF', $specials_item);
      }
    }
  }
