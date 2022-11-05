<?php
/**
 * Mod List by That Software Guy
 * @copyright Copyright 2015 That Software Guy
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

  require('includes/application_top.php');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" href="includes/stylesheet.css">
<link rel="stylesheet" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div style="margin:2px;">
<h1><?php echo HEADING_TITLE; ?></h1>

<h2><?php echo PAGES_TABLE; ?></h2>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
              <!-- this is the heading row -->
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left" valign="top">
                  <?php echo HEADING_PAGE_NAME; ?>
                </td>
                <td class="dataTableHeadingContent" align="left" valign="top">
                  <?php echo HEADING_PAGE_MENU_KEY; ?><br>
                </td>
                <td class="dataTableHeadingContent" align="left" valign="top">
                  <?php echo HEADING_DISPLAY; ?><br>
                </td>
                <td class="dataTableHeadingContent" align="left" valign="top">
                  <?php echo HEADING_PAGE_LINK; ?><br>
                </td>
              </tr>
              <!-- end heading row -->
<?php
    $new_pages = array();
    $pages_query_raw = " SELECT * FROM " . TABLE_ADMIN_PAGES;
    $pages = $db->Execute($pages_query_raw);
    if ($pages->RecordCount() <= 0) {
?>
      <tr><td colspan="3" align="left"><?php echo '<b>' . NO_PAGES_TABLE_FOUND . '</b>'; ?></td></tr>
<?php
    } else {
       while (!$pages->EOF) {
          $key = $pages->fields['language_key'];
          if (in_array($key, BUILT_IN_BOXES)) {
             $pages->MoveNext();
             continue;
          }
   ?>
                <tr>
                   <td class="dataTableContent" align="left">
                   <?php
                      if (defined($pages->fields['language_key']))
                         echo constant($pages->fields['language_key']);
                      else
                         echo "(" . $pages->fields['language_key'] . ")";
                   ?>
                   </td>
                   <td class="dataTableContent">
   <?php
                         echo $pages->fields['menu_key'];
   ?>
                   </td>
                   <td class="dataTableContent">
   <?php
                         echo $pages->fields['display_on_menu'];
   ?>
                   </td>
                   <td class="dataTableContent">
                   <?php
                      if (defined($pages->fields['language_key']) &&
                          defined($pages->fields['main_page'])) {
                         echo '<a href="' . zen_href_link(constant($pages->fields['main_page']), $pages->fields['page_params']) .'">' . constant($pages->fields['language_key']) . '</a>';
                      } else {
                         echo NO_LINK;
                      }
                   ?>
                   </td>
                 </tr>
   <?php
         $pages->MoveNext();
       }
    }
?>
</table>

<h2><?php echo DB_LIST; ?></h2>
<?php
    $new_pages = array();
    $tables_query_raw = "SELECT TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA = '" . DB_DATABASE . "'";
    $tables = $db->Execute($tables_query_raw);
    if ($tables->RecordCount() <= 0) {
?>
      <tr><td colspan="3" align="left"><?php echo '<b>' . NO_INFORMATION_SCHEMA_TABLE_FOUND . '</b>'; ?></td></tr>
<?php
    } else {
       echo "<ul>";
       while (!$tables->EOF) {
          $key = $tables->fields['TABLE_NAME'];
          if (DB_PREFIX != '') {
             $key = substr($key, strlen(DB_PREFIX));
          }
          if (in_array($key, BUILT_IN_TABLES) ||
              in_array($key, OPTIONAL_TABLES)) {
             $tables->MoveNext();
             continue;
          }
          echo '<li>' . $tables->fields['TABLE_NAME'] . '</li>';
          $tables->MoveNext();
       }
       echo "</ul>";
    }
?>

<h2><?php echo MODULE_LIST; ?></h2>
<ul>
<?php
  echo '<li>' . BOX_MODULES_PAYMENT. ": ";
  $list = explode (';', MODULE_PAYMENT_INSTALLED);
  $i = 0;
  foreach ($list as $item) {
     if (!in_array($item, BUILT_IN_PAYMENTS)) {
         $i++;
         echo $item . ' ';
     }
  }
  if ($i == 0) echo NO_EXTRAS;
  echo "</li>\n";

  echo '<li>' . BOX_MODULES_SHIPPING. ": ";
  $list = explode (';', MODULE_SHIPPING_INSTALLED);
  $i = 0;
  foreach ($list as $item) {
     if (!in_array($item, BUILT_IN_SHIPPINGS)) {
         $i++;
         echo $item . ' ';
     }
  }
  if ($i == 0) echo NO_EXTRAS;
  echo "</li>\n";

  echo '<li>' . BOX_MODULES_ORDER_TOTAL. ": ";
  $list = explode (';', MODULE_ORDER_TOTAL_INSTALLED);
  $i = 0;
  foreach ($list as $item) {
     if (!in_array($item, BUILT_IN_ORDER_TOTALS)) {
         $i++;
         echo $item . ' ';
     }
  }
  if ($i == 0) echo NO_EXTRAS;
  echo "</li>\n";
?>
</ul>

<h2><?php echo MISSING_ADMIN_PAGES; ?></h2>
<?php echo '<div class="smallText">' . MISSING_ADMIN_PAGES_WHY . '</div>'; ?>
<br>
<?php
    $missing_pages = array();
    $pages_query_raw = " SELECT * FROM " . TABLE_CONFIGURATION_GROUP . " WHERE visible = '1'" ;
    $pages = $db->Execute($pages_query_raw);
    while (!$pages->EOF) {
       $gid = $pages->fields['configuration_group_id'];
       $admin_entry = $db->Execute("SELECT * FROM " . TABLE_ADMIN_PAGES . " WHERE page_params = 'gid=". (int)$gid . "'");
       if ($admin_entry->EOF) {
           $missing_pages[] = array('gid' => $gid,
                                    'name' => $pages->fields['configuration_group_title']);
       }
       $pages->MoveNext();
    }
    if (sizeof($missing_pages) > 0) {
       echo "<ul>";
       foreach ($missing_pages as $missing_page) {
          echo "<li>";
          echo '<a href="' . zen_href_link(FILENAME_CONFIGURATION, "gID=" . (int)$missing_page['gid']) .'">' . $missing_page['name'] . '</a>';
          echo "</li>";
       }
       echo "</ul>";
    } else {
      echo NO_MISSING_ADMIN_PAGES;
    }
?>


</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
