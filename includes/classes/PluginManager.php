<?php
/**
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Zcwilt 2020 May 23 New in v1.5.7 $
 */

namespace Zencart\PluginManager;

class PluginManager
{

    public function __construct($dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function inspectAndUpdate()
    {
        $pluginsFromFilesystem = $this->getPluginsFromFileSystem();

        $this->updateDbPlugins($pluginsFromFilesystem);

    }

    public function getInstalledPlugins()
    {
        $sql = "SELECT * FROM " . TABLE_PLUGIN_CONTROL . " WHERE status = 1";
        $results = $this->dbConn->execute($sql, false, true, 150);
        $pluginList = [];
        foreach ($results as $result) {
            $pluginList[$result['unique_key']] = $result;
        }
        return $pluginList;
    }

    public function getPluginVersionDirectory($pluginName, $installedPlugins)
    {
        if (!array_key_exists($pluginName, $installedPlugins)) {
            return null;
        }
        $filePath = DIR_FS_CATALOG . 'zc_plugins/' . $pluginName . '/' . $installedPlugins[$pluginName]['version'] . '/';
        return $filePath;
    }

    public function isUpgradeAvailable($uniqueKey, $currentVersion)
    {
        if (empty($currentVersion)) return false;
        $versionList = $this->getVersionsForUpgrade($uniqueKey, $currentVersion);
        return count($versionList);
    }

    public function getVersionsForUpgrade($uniqueKey, $currentVersion)
    {
        if (empty($currentVersion)) return [];
        $versions = $this->getPluginVersions($uniqueKey);
        $versionList = [];
        foreach ($versions as $version) {
            if (version_compare($version['version'], $currentVersion, '<=')) continue;
            $versionList[$version['version']] = $version['version'];
        }
        return $versionList;
    }
    protected function getPluginVersions($uniqueKey)
    {
        $sql = "SELECT version FROM " . TABLE_PLUGIN_CONTROL_VERSIONS . " WHERE unique_key = :uniqueKey:";
        $sql = $this->dbConn->bindVars($sql, ':uniqueKey:', $uniqueKey, 'string');
        $result = $this->dbConn->execute($sql);
        return $result;
    }

    protected function getPluginsFromFileSystem()
    {
        $pluginDir = DIR_FS_CATALOG . 'zc_plugins';
        $pluginList = [];
        $dir = new \DirectoryIterator($pluginDir);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDot() || !$fileinfo->isDir()) {
                continue;
            }
            $versionInfo = $this->getPluginVersionDirectories($fileinfo);
            if (count($versionInfo) == 0) continue;
            $pluginList = $this->mergeInVersionInfo($pluginList, $fileinfo->getFilename(), $versionInfo);
        }
        return $pluginList;
    }

    protected function getPluginVersionDirectories($parent)
    {
        $versionList = [];
        $dir = new \DirectoryIterator($parent->getPathName());
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDot() || !$fileinfo->isDir()) {
                continue;
            }
            if (!file_exists($fileinfo->getPathname() . '/manifest.php')) {
                continue; //@todo consider throwing exception/triger_error here
            }
            $manifest = require $fileinfo->getPathname() . '/manifest.php';
            $versionList[$fileinfo->getFilename()] = $manifest;
        }
        return $versionList;
    }

    protected function getPluginsFromDb()
    {
        $pluginList = [];
        $sql = "SELECT * FROM " . TABLE_PLUGIN_CONTROL;
        $results = $this->dbConn->execute($sql);
        foreach ($results as $result) {
            $pluginList[$result['unique_key']] = $result;
        }
        return $pluginList;
    }

    protected function updateDbPlugins($pluginsFromFilesystem)
    {
        if (count($pluginsFromFilesystem) === 0) {
            return;
        }
// @todo validate plugin entries here
        $this->updatePluginControl($pluginsFromFilesystem);
        $this->updatePluginControlVersions($pluginsFromFilesystem);
    }

    protected function updatePluginControl($pluginsFromFilesystem)
    {
        $sql = "UPDATE " . TABLE_PLUGIN_CONTROL . " SET infs = 0";
        $this->dbConn->execute($sql);
        $sql = "INSERT INTO " . TABLE_PLUGIN_CONTROL . " 
        (unique_key, name, description, type, status, author, version, zc_versions, infs) 
        VALUES ";

        foreach ($pluginsFromFilesystem as $uniqueKey => $plugin) {
            $pluginVersion = $plugin['versions'][0];
            $sqlPartial = "(:unique_key:, :name:, :description:, '', 0, :author:, '', '', 1),";
            $sqlPartial = $this->dbConn->bindVars($sqlPartial, ':unique_key:', $uniqueKey, 'string');
            $sqlPartial = $this->dbConn->bindVars($sqlPartial, ':name:', $plugin[$pluginVersion]['pluginName'],
                                                  'string');
            $sqlPartial = $this->dbConn->bindVars($sqlPartial, ':description:', $plugin[$pluginVersion]['pluginDescription'],
                                                  'string');
            $sqlPartial = $this->dbConn->bindVars($sqlPartial, ':author:', $plugin[$pluginVersion]['pluginAuthor'], 'string');
            $sql .= $sqlPartial;
        }
        $sql = rtrim($sql, ',');
        $sql .= " ON DUPLICATE KEY UPDATE infs = 1";
        $this->dbConn->execute($sql);
        $sql = "DELETE FROM " .TABLE_PLUGIN_CONTROL . " WHERE infs = 0";
        $this->dbConn->execute($sql);

    }

    protected function updatePluginControlVersions($pluginsFromFilesystem)
    {
        $sql = "UPDATE " . TABLE_PLUGIN_CONTROL_VERSIONS . " SET infs = 0";
        $this->dbConn->execute($sql);
        $sqlPluginVersion = "INSERT INTO " . TABLE_PLUGIN_CONTROL_VERSIONS . "
        (unique_key, author, version, zc_versions, infs) VALUES ";

        foreach ($pluginsFromFilesystem as $uniqueKey => $plugin) {
            $sqlPluginVersion .= $this->processUpdateVersions($uniqueKey, $pluginsFromFilesystem);
        }
        $sqlPluginVersion = rtrim($sqlPluginVersion, ',');
        $sqlPluginVersion .= " ON DUPLICATE KEY UPDATE infs = 1";
        $this->dbConn->execute($sqlPluginVersion);
        $sql = "DELETE FROM " .TABLE_PLUGIN_CONTROL_VERSIONS . " WHERE infs = 0";
        $this->dbConn->execute($sql);
    }

    protected function processUpdateVersions($uniqueKey, $pluginsFromFilesystem)
    {
        $currentPlugin = $pluginsFromFilesystem[$uniqueKey];
        $extraSql = '';
        foreach ($currentPlugin as $version => $versionInfo) {
            if ($version == 'versions') {
                continue;
            }
            $extraSql .= "(:unique_key:, :author:, :version:, :zc_versions:, 1),";
            $extraSql = $this->dbConn->bindVars($extraSql, ':unique_key:', $uniqueKey, 'string');
            $extraSql = $this->dbConn->bindVars($extraSql, ':author:', $versionInfo['pluginAuthor'], 'string');
            $extraSql = $this->dbConn->bindVars($extraSql, ':version:', $version, 'string');
            $extraSql = $this->dbConn->bindVars($extraSql, ':zc_versions:', json_encode($versionInfo['zcVersions']),
                                                'string');
        }
        return $extraSql;
    }

    protected function mergeInVersionInfo($pluginList, $uniqueKey, $versionInfo)
    {
        $versionList = [];
        foreach ($versionInfo as $version => $detail) {
            $pluginList[$uniqueKey][$version] = $detail;
            $versionList[] = $version;
        }
        usort($versionList, 'version_compare');
        $versionList = array_reverse($versionList);
        $pluginList[$uniqueKey]['versions'] = $versionList;
        return $pluginList;
    }

    public function getPluginVersionsForPlugin($uniqueKey)
    {
        $sql = "SELECT * FROM " . TABLE_PLUGIN_CONTROL_VERSIONS . " WHERE unique_key = :uniqueKey:";
        $sql = $this->dbConn->bindVars($sql, ':uniqueKey:', $uniqueKey, 'string');
        $results = $this->dbConn->execute($sql, false, true, 150);
        $versions = [];
        foreach ($results as $result) {
            $versions[$result['version']] = $result;
        }
        ksort($versions);
        $versions = array_reverse($versions);
        return $versions;
    }

    public function getPluginVersionsToClean($uniqueKey, $version)
    {
        $versions = $this->getPluginVersionsForPlugin($uniqueKey);
        unset($versions[$version]);
        return $versions;
    }

    public function hasPluginVersionsToClean($uniqueKey, $version)
    {
        return count($this->getPluginVersionsToClean($uniqueKey, $version));
    }

}