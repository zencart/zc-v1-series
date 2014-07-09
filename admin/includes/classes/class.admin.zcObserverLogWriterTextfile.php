<?php
/**
 * @package plugins
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Jun 30 2014 Modified in v1.5.4 $
 *
 * Designed for ZC >= v1.5.4
 *
 */

class zcObserverLogWriterTextfile extends base {

  public function __construct() {
    global $zco_notifier;

    $zco_notifier->attach($this, array('NOTIFY_ADMIN_FIRE_LOG_WRITERS'));

    /**
     * The following specifies the folderpath on the filesystem where the data will be logged
     */
    $this->destinationLogFilename = DIR_FS_LOGS . '/admin_log.txt';

  }

  public function updateNotifyAdminFireLogWriters(&$class, $eventID, $log_data)
  {
    $this->initLogFile();
    /**
     * The observer's $paramsArray contains the data passed to the notifier hook.
     * That data is json-encoded here, and then stored to
     * a custom specified text file on the filesystem using PHP error_log() function.
     */
    $data = json_encode($log_data);

    error_log($log_data['severity'] . ' [' . date('M-d-Y H:i:s') . '] ' . $log_data['ip_address'] . ' ' . $data . "\n", 3, $this->destinationLogFilename);
  }

  /**
   * PCI requires that if the log is blank, that the logs be initialized
   * So this tests whether the logging file exists, creates it if necessary, and
   * then if the file is empty initializes it
   */
  private function initLogFile()
  {
    $init_required = false;
    if (!file_exists($this->destinationLogFilename))
    {
      touch($this->destinationLogFilename);
      $init_required = true;
    } else {
      $val = file_get_contents($this->destinationLogFilename, null, null, null, 100);
      if ($val === false || strlen($val) < 20) {
        $init_required = true;
      }
    }
    if ($init_required)
    {
      /**
       * builds a json-encoded array here, for consistency with normal logging
       */
      $admin_id = (isset($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : 0;
      $data = array('access_date' => date('M-d-Y H:i:s'),
              'admin_id' => (int)$admin_id,
              'page_accessed' =>  'Log found to be empty. Logging started.',
              'page_parameters' => '',
              'ip_address' => substr($_SERVER['REMOTE_ADDR'],0,45),
              'gzpost' => '',
              'flagged' => 0,
              'attention' => '',
              'severity' => 'notice',
      );
      $data = json_encode($data);

      error_log('notice [' . date('M-d-Y H:i:s') . '] ' . substr($_SERVER['REMOTE_ADDR'],0,45) . ' ' . 'Log found to be empty. Logging started.' . "\n", 3, $this->destinationLogFilename);
      error_log('notice [' . date('M-d-Y H:i:s') . '] ' . substr($_SERVER['REMOTE_ADDR'],0,45) . ' ' . $data . "\n", 3, $this->destinationLogFilename);
    }
  }

}
