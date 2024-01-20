<?php

/**
 * Database-Sniffer Class.
 *
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: dbltoe 2022 Nov 10 Modified in v1.5.8a $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

/**
 * Database-Sniffer Class
 *
 * This class is used to inspect database table structures.
 * The most common use for this is for ensuring that the database structure matches the expected format for certain internal features that have upgraded or changed.
 * It is also used by plugins which add additional fields to the database, to check which changes are needed before making them.
 *
 */
class sniffer extends base
{
    /**
     * Check to see if the requested table exists
     */
    public function table_exists(string $table_name): bool
    {
        global $db;
        $sql = "SHOW TABLES like '" . $table_name . "'";
        $result = $db->Execute($sql);
        return $result->RecordCount() > 0;
    }

    /**
     * Check whether the field exists in the table
     */
    public function field_exists(string $table_name, string $field_name): bool
    {
        global $db;
        $sql = "SHOW FIELDS FROM " . $table_name;
        $result = $db->Execute($sql);
        foreach ($result as $record) {
            if ($record['Field'] === $field_name) {
                return true; // exists, so return with no error
            }
        }
        return false;
    }

    /**
     * Check whether a field is a specific type
     * and optionally return what type it is, if not matching what is being checked for.
     */
    public function field_type(string $table_name, string $field_name, string $field_type, bool $return_found = false): bool|string
    {
        global $db;
        $sql = "SHOW FIELDS FROM " . $table_name;
        $result = $db->Execute($sql);
        foreach($result as $record) {
            if ($record['Field'] === $field_name) {
                if ($record['Type'] === $field_type) {
                    return true; // exists and matches required type, so return with no error
                }

                if ($return_found) {
                    return $record['Type']; // doesn't match, so return what it "is", if requested
                }
            }
        }
        return false;
    }

    /**
     * Return true if the specified row exists in the table.
     *
     * @param string $table_name The table to query.
     * @param string $key_name The key to check.
     * @param int $key_value The value that key_name must equal.
     * @return bool
     */
    public function rowExists(string $table_name, string $key_name, int $key_value): bool
    {
        global $db;
        $sql = 'SELECT COUNT(*) AS count FROM :table_name WHERE :key_name = :key_value;';
        $sql = $db->bindVars($sql, ':key_name', $key_name, 'passthru');
        $sql = $db->bindVars($sql, ':key_value', $key_value, 'integer');
        $sql = $db->bindVars($sql, ':table_name', $table_name, 'passthru');
        $result = $db->Execute($sql);
        return (int)$result->fields['count'] !== 0;
    }

    /**
     * Return true if the specified row exists in the table.
     * Key column names taken from $key_names are matched against equivalent
     * key values in $key_values.
     *
     * @param string $table_name The table to query.
     * @param array $key_names The array of keys to check.
     * @param array $key_values The array of values that key_names must equal.
     * @return bool
     */
    public function rowExistsComposite(string $table_name, array $key_names, array $key_values): bool
    {
        global $db;
        $sql = 'SELECT COUNT(*) AS count FROM :table_name WHERE ';
        $sql .= implode(
            ' AND ',
            array_map(
                static function ($key, $value) {
                    global $db;
                    $bit = ':key = :value';
                    $bit = $db->bindVars($bit, ':key', $key, 'passthru');
                    $bit = $db->bindVars($bit, ':value', $value, 'integer');
                    return $bit;
                },
                $key_names,
                $key_values
            )
        );
        $sql = $db->bindVars($sql, ':table_name', $table_name, 'passthru');
        $result = $db->Execute($sql);
        return (int)$result->fields['count'] !== 0;
    }
}
