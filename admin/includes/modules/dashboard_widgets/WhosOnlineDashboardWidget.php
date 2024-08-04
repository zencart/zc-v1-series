<?php
/**
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Nick Fenwick 2023 Jul 03 Modified in v2.0.0-alpha1 $
 */

if (!zen_is_superuser() && !check_page(FILENAME_WHOS_ONLINE, '')) return;

// to disable this module for everyone, uncomment the following "return" statement so the rest of this file is ignored
// return;


$whos_online = new WhosOnline();
$whos_online_stats = $whos_online->getStats();
$user_array = $whos_online_stats['user_array'];
$guest_array = $whos_online_stats['guest_array'];
$spider_array = $whos_online_stats['spider_array'];

?>
  <div class="card reportBox mb-3">
    <div class="card-header header">
        <?php echo WO_GRAPH_TITLE . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_WHOS_ONLINE) . '">' . WO_GRAPH_MORE . '</a>'; ?>
    </div>
      <div class="table-responsive">
      <table class="table table-striped table-condensed">
      <tr>
        <td><?php echo WO_GRAPH_REGISTERED; ?></td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-lime"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($user_array[0] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-orange"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($user_array[1] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-red"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($user_array[2] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-pink"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($user_array[3] ?: ''); ?>
        </td>
      </tr>
      <tr>
        <td><?php echo WO_GRAPH_GUEST; ?></td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-lime"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($guest_array[0] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-orange"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($guest_array[1] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-red"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($guest_array[2] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-pink"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($guest_array[3] ?: ''); ?>
        </td>
      </tr>
      <tr>
        <td><?php echo WO_GRAPH_SPIDER; ?></td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-lime"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($spider_array[0] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-orange"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($spider_array[1] ?: ''); ?></td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-red"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($spider_array[2] ?: ''); ?>
        </td>
        <td>
          <span class="fa-stack fa-lg">
            <i class="fa-solid fa-circle fa-stack-1x txt-pink"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;&nbsp;<?php echo ($spider_array[3] ?: ''); ?>
        </td>
      </tr>
      <tr>
        <td colspan="4"><?php echo WO_GRAPH_TOTAL; ?></td>
        <td class="text-right"><?php echo $whos_online->getTotalSessions(); ?></td>
      </tr>
      <tr class="smallText">
        <td colspan="5">
          <span class="fa-stack">
            <i class="fa-solid fa-circle fa-stack-1x txt-lime"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;<?php echo WHOS_ONLINE_ACTIVE_TEXT; ?>&nbsp;&nbsp;
          <span class="fa-stack">
            <i class="fa-solid fa-circle fa-stack-1x txt-orange"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;<?php echo WHOS_ONLINE_INACTIVE_TEXT; ?>&nbsp;&nbsp;
          <span class="fa-stack">
            <i class="fa-solid fa-circle fa-stack-1x txt-red"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;<?php echo WHOS_ONLINE_ACTIVE_NO_CART_TEXT; ?>&nbsp;&nbsp;
          <span class="fa-stack">
            <i class="fa-solid fa-circle fa-stack-1x txt-pink"></i>
            <i class="fa-regular fa-circle fa-stack-1x"></i>
          </span>&nbsp;<?php echo WHOS_ONLINE_INACTIVE_NO_CART_TEXT; ?>
        </td>
      </tr>
    </table>
      </div>
  </div>
