<?php
/**
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: lat9 2024 May 28 Modified in v2.1.0-alpha1 $
 */

namespace Zencart\PluginSupport;

use queryFactory;

class ScriptedInstaller
{
    use ScriptedInstallHelpers;

    protected queryFactory $dbConn;
    protected PluginErrorContainer $errorContainer;

    public function __construct($dbConn, $errorContainer)
    {
        $this->dbConn = $dbConn;
        $this->errorContainer = $errorContainer;
    }

    public function doInstall()
    {
        $installed = $this->executeInstall();
        return $installed;
    }

    public function doUninstall()
    {
        $uninstalled = $this->executeUninstall();
        return $uninstalled;
    }

    public function doUpgrade($oldVersion)
    {
        $upgraded = $this->executeUpgrade($oldVersion);
        return $upgraded;
    }

    protected function executeInstall()
    {
        return true;
    }

    protected function executeUninstall()
    {
        return true;
    }

    protected function executeUpgrade($oldVersion)
    {
        return true;
    }

    protected function executeInstallerSql($sql)
    {
        $this->dbConn->dieOnErrors = false;
        $this->dbConn->Execute($sql);
        if ($this->dbConn->error_number !== 0) {
            $this->errorContainer->addError(0, $this->dbConn->error_text, true, PLUGIN_INSTALL_SQL_FAILURE);
            return false;
        }
        $this->dbConn->dieOnErrors = true;
        return true;
    }
}
