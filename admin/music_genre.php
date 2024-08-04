<?php
/**
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: neekfenwick 2023 Dec 09 Modified in v2.0.0-alpha1 $
 */
require('includes/application_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');

if (!empty($action)) {
  switch ($action) {
    case 'insert':
    case 'save':
      if (isset($_GET['mID'])){
      $music_genre_id = zen_db_prepare_input($_GET['mID']);}
      $music_genre_name = zen_db_prepare_input($_POST['music_genre_name']);

      $sql_data_array = array('music_genre_name' => $music_genre_name);

      if ($action == 'insert') {
        $insert_sql_data = array('date_added' => 'now()');

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        zen_db_perform(TABLE_MUSIC_GENRE, $sql_data_array);
        $music_genre_id = zen_db_insert_id();
      } elseif ($action == 'save') {
        $update_sql_data = array('last_modified' => 'now()');

        $sql_data_array = array_merge($sql_data_array, $update_sql_data);

        zen_db_perform(TABLE_MUSIC_GENRE, $sql_data_array, 'update', "music_genre_id = " . (int)$music_genre_id);
      }

      zen_redirect(zen_href_link(FILENAME_MUSIC_GENRE, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'mID=' . $music_genre_id));
      break;
    case 'deleteconfirm':
      $music_genre_id = zen_db_prepare_input($_POST['mID']);

      $db->Execute("DELETE FROM " . TABLE_MUSIC_GENRE . "
                    WHERE music_genre_id = " . (int)$music_genre_id);

      if (isset($_POST['delete_products']) && ($_POST['delete_products'] == 'on')) {
        $products = $db->Execute("SELECT products_id
                                  FROM " . TABLE_PRODUCT_MUSIC_EXTRA . "
                                  WHERE music_genre_id = " . (int)$music_genre_id);

        foreach ($products as $product) {
          zen_remove_product($product['products_id']);
        }
      } else {
        $db->Execute("UPDATE " . TABLE_PRODUCT_MUSIC_EXTRA . "
                      SET music_genre_id = 0
                      WHERE music_genre_id = " . (int)$music_genre_id);
      }

      zen_redirect(zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page']));
      break;
  }
}
?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
  <head>
    <?php require DIR_WS_INCLUDES . 'admin_html_head.php'; ?>
  </head>
  <body>
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->
    <div class="container-fluid">
      <!-- body //-->
      <h1 class="pageHeading"><?php echo HEADING_TITLE; ?></h1>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 configurationColumnLeft">
            <div class="table-responsive">
            <table class="table table-hover table-striped">
            <thead class="table-dark">
              <tr class="dataTableHeadingRow">
                <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_MUSIC_GENRE; ?></th>
                <th class="dataTableHeadingContent text-right"><?php echo TABLE_HEADING_ACTION; ?></th>
              </tr>
            </thead>
            <tbody>
                <?php
                $music_genre_query_raw = "SELECT *
                                          FROM " . TABLE_MUSIC_GENRE . "
                                          ORDER BY music_genre_name";
                $music_genre_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $music_genre_query_raw, $music_genre_query_numrows);
                $music_genres = $db->Execute($music_genre_query_raw);
                $mGenre_parameter = '';
                foreach ($music_genres as $music_genre) {
                  if ((!isset($_GET['mID']) || (isset($_GET['mID']) && ($_GET['mID'] == $music_genre['music_genre_id']))) && !isset($aInfo) && (substr($action, 0, 3) != 'new')) {
                    $music_genre_products = $db->Execute("SELECT COUNT(*) AS products_count
                                                          FROM " . TABLE_PRODUCT_MUSIC_EXTRA . "
                                                          WHERE music_genre_id = " . (int)$music_genre['music_genre_id']);

                    $aInfo_array = array_merge($music_genre, $music_genre_products->fields);
                    $aInfo = new objectInfo($aInfo_array);
					$mGenre_parameter = '&mID=' . $aInfo->music_genre_id;
                  }

                  if (isset($aInfo) && is_object($aInfo) && ($music_genre['music_genre_id'] == $aInfo->music_genre_id)) {
                    ?>
                  <tr id="defaultSelected" class="dataTableRowSelected" onclick="document.location.href='<?php echo zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . '&mID=' . $music_genre['music_genre_id'] . '&action=edit'); ?>'">
                    <?php } else { ?>
                  <tr class="dataTableRow" onclick="document.location.href='<?php echo zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . '&mID=' . $music_genre['music_genre_id'] . '&action=edit'); ?>'">
                    <?php } ?>
                  <td class="dataTableContent"><?php echo $music_genre['music_genre_name']; ?></td>
                  <td class="dataTableContent text-right">
                      <?php
                      if (isset($aInfo) && is_object($aInfo) && ($music_genre['music_genre_id'] == $aInfo->music_genre_id)) {
                        echo zen_icon('caret-right', '', '2x', true);
                      } else {
                        echo '<a href="' . zen_href_link(FILENAME_MUSIC_GENRE, zen_get_all_get_params(array('mID')) . 'mID=' . $music_genre['music_genre_id']) . '" data-toggle="tooltip" title="' . IMAGE_ICON_INFO . '" role="button">' . zen_icon('circle-info', '', '2x', true, false) . '</a>';
                      }
                      ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 configurationColumnRight">
            <?php
            $heading = array();
            $contents = array();

            switch ($action) {
              case 'new':
                $heading[] = array('text' => '<h4>' . TEXT_HEADING_NEW_MUSIC_GENRE . '</h4>');
                $contents = array('form' => zen_draw_form('music_genre', FILENAME_MUSIC_GENRE, 'action=insert', 'post', 'enctype="multipart/form-data"'));
                $contents[] = array('text' => TEXT_NEW_INTRO);
                $contents[] = array('text' => zen_draw_label(TEXT_MUSIC_GENRE_NAME, 'music_genre_name', 'class="form-label"') . zen_draw_input_field('music_genre_name', '', zen_set_field_length(TABLE_MUSIC_GENRE, 'music_genre_name') . ' class="form-control"'));
                $contents[] = array('align' => 'center', 'text' => '<button type="submit" class="btn btn-primary">' . IMAGE_SAVE . '</button> <a href="' . zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . (isset($_GET['mID']) ? '&mID=' . $_GET['mID'] : '')) . '" class="btn btn-secondary" role="button">' . IMAGE_CANCEL . '</a>');
                break;
              case 'edit':
                $heading[] = array('text' => '<h4>' . TEXT_HEADING_EDIT_MUSIC_GENRE . '</h4>');
                $contents = array('form' => zen_draw_form('music_genre', FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . $mGenre_parameter . '&action=save', 'post', 'enctype="multipart/form-data"'));
                $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
                $contents[] = array('text' => zen_draw_label(TEXT_MUSIC_GENRE_NAME, 'music_genre_name', 'class="form-label"') . zen_draw_input_field('music_genre_name', htmlspecialchars($aInfo->music_genre_name, ENT_COMPAT, CHARSET, TRUE), zen_set_field_length(TABLE_MUSIC_GENRE, 'music_genre_name') . ' class="form-control"'));
                $contents[] = array('align' => 'center', 'text' => '<button type="submit" class="btn btn-primary">' . IMAGE_SAVE . '</button> <a href="' . zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . $mGenre_parameter) . '" class="btn btn-secondary" role="button">' . IMAGE_CANCEL . '</a>');
                break;
              case 'delete':
                $heading[] = array('text' => '<h4>' . TEXT_HEADING_DELETE_MUSIC_GENRE . '</h4>');

                $contents = array('form' => zen_draw_form('music_genre', FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . '&action=deleteconfirm') . zen_draw_hidden_field('mID', $aInfo->music_genre_id));
                $contents[] = array('text' => TEXT_DELETE_INTRO);
                $contents[] = array('text' => '<br><b>' . $aInfo->music_genre_name . '</b>');

                if ($aInfo->products_count > 0) {
                  $contents[] = array('text' => '<div class="checkbox"><label>' . zen_draw_checkbox_field('delete_products') . TEXT_DELETE_PRODUCTS . '</label></div>');
                  $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $aInfo->products_count));
                }

                $contents[] = array('align' => 'center', 'text' => '<button type="submit" class="btn btn-danger">' . IMAGE_DELETE . '</button> <a href="' . zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . $mGenre_parameter) . '" class="btn btn-secondary" role="button">' . IMAGE_CANCEL . '</a>');
                break;
              default:
                if (isset($aInfo) && is_object($aInfo)) {
                  $heading[] = array('text' => '<h4>' . $aInfo->music_genre_name . '</h4>');

                  $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . $mGenre_parameter . '&action=edit') . '" class="btn btn-primary" role="button">' . IMAGE_EDIT . '</a> <a href="' . zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . $mGenre_parameter . '&action=delete') . '" class="btn btn-warning" role="button">' . IMAGE_DELETE . '</a>');
                  $contents[] = array('text' => '<br>' . TEXT_INFO_DATE_ADDED . ' ' . zen_date_short($aInfo->date_added));
                  if (zen_not_null($aInfo->last_modified)) {
                    $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . ' ' . zen_date_short($aInfo->last_modified));
                  }
                  $contents[] = array('text' => '<br>' . TEXT_PRODUCTS . ' ' . $aInfo->products_count);
                }
                break;
            }

            if (!empty($heading) && !empty($contents)) {
              $box = new box;
              echo $box->infoBox($heading, $contents);
            }
            ?>
        </div>
      </div>
        <div class="table-responsive">
        <table class="table">
        <tr>
          <td><?php echo $music_genre_split->display_count($music_genre_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_MUSIC_GENRES); ?></td>
          <td class="text-right"><?php echo $music_genre_split->display_links($music_genre_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
        </tr>
        <?php if (empty($action)) { ?>
          <tr>
            <td colspan="2" class="text-right"><a href="<?php echo zen_href_link(FILENAME_MUSIC_GENRE, 'page=' . $_GET['page'] . $mGenre_parameter . '&action=new'); ?>" class="btn btn-primary" role="button"><?php echo IMAGE_INSERT; ?></a></td>
          </tr>
        <?php } ?>
      </table>
        </div>
      <!-- body_text_eof //-->

      <!-- body_eof //-->
    </div>
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
