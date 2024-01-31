<?php

/**
 * Try to match the HTTP_REFERER header against our coupon records.
 *
 * @return ?string the coupon_code if found, else null.
 */
function initCouponReferrerCheck(): ?string {
    global $db;

    if (empty($_SERVER['HTTP_REFERER'])) {
        // There is no referer header, cannot do any lookup.
        return null;
    }
    $referrer = $_SERVER['HTTP_REFERER'];

    // Check for coupon that probably matches this referer.  More expensive validation done later.
    // Strip the domain name from the URL e.g. https://www.blah.com/page.html becomes blah.com
    $matches = [];
    $result = preg_match('/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n?]+)/', $referrer, $matches);
    if ($result !== 1) {
        return null;
    }
    $domain = $matches[1];

    $sql = "SELECT coupon_code, referrer
        FROM " . TABLE_COUPONS . "
        WHERE referrer LIKE '%:referrer:%'";
    $sql = $db->bindVars($sql, ':referrer:', $domain, 'noquotestring');

    $result = $db->Execute($sql, 1);

    if ($result->EOF) {
        return null;
    }

    return $result->fields['coupon_code'];
}

/**
 * Return a coupon code found in $_GET['coupon_code'], if any.
 *
 * @return ?string the coupon_code if found, else null.
 */
function initCouponRequestCheck() {
    if (empty($_GET['coupon_code'])) {
        return null;
    }
    return zen_db_prepare_input($_GET['coupon_code']);
}

/**
 * Look for any coupon_code, validate it and apply it.
 *
 * @return void
 */
function initCouponChecks() {
    global $languageLoader, $messageStack;
    $coupon_code = initCouponRequestCheck();
    if (empty($coupon_code)) {
        $coupon_code = initCouponReferrerCheck();
    }
    if (empty($coupon_code)) {
        return;
    }

    // Load the ot_coupon module and its lang strings, for more validation.
    $module_file = DIR_WS_MODULES . 'order_total/ot_coupon.php';
    include_once($module_file);
    $languageLoader->loadExtraLanguageFiles(DIR_FS_CATALOG . DIR_WS_LANGUAGES, $_SESSION['language'], 'ot_coupon.php', '/modules/order_total');
    $ot_coupon = new ot_coupon;
    if (!$ot_coupon->check()) {
        return;
    }

    $coupon_id = $ot_coupon->performValidations($coupon_code);
    if (empty($coupon_id)) {
        // The coupon could not be applied for some reason
        $ot_coupon->setMessageStackValidationAlerts();
        return;
    }

    if (!empty($_SESSION['cc_id']) && $_SESSION['cc_id'] === $coupon_id) {
        // The coupon is already active.
        return;
    }

    // We found and validated the coupon successfully.
    $_SESSION['cc_id'] = $coupon_id;
    $messageStack->add('header', TEXT_VALID_COUPON, 'success');
}

initCouponChecks();