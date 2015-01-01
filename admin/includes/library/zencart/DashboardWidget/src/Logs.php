<?php
/**
 * Logs Dashboard Widget
 *
 * @package classes
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: $
 */

namespace ZenCart\Admin\DashboardWidget;

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

/**
 * Logs Class
 *
 * @package classes
 */
class Logs extends AbstractWidget
{
  public function prepareContent()
  {
    $tplVars = array();

    $count = get_logs_data('count');
    if ($count == 0) {
     $tplVars['content'][] = array('text'=>TEXT_NO_LOGFILES_FOUND, 'value'=>'');
     return $tplVars;
    }

    // @TODO - in future when widgets support configurable settings, allow this number to be set there.
    $max_logs_to_list = 20;

    $logs = get_logs_data($max_logs_to_list);
    // keys in $logs are: 'path', 'filename', 'filesize', 'unixtime', 'datetime'

    foreach ($logs as $log) {
      $tplVars['content'][] = array(
                                    'text'=> $log['filename'], // @TODO future: add clickable link to ajax-driven viewer here
                                    'value'=>$log['filesize'],
                                    );
    }

    // display summary
    $final_message = sprintf(TEXT_TOTAL_LOGFILES_FOUND, $count);
    if ($count > $max_logs_to_list) {
      $final_message .= sprintf(TEXT_DISPLAYING_RECENT_COUNT, $max_logs_to_list);
    }
    $tplVars['content'][] = array('text'=> $final_message, 'value'=> '');

    return $tplVars;
  }
}
