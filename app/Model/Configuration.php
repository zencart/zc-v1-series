<?php
/**
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: $
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Configuration extends Eloquent
{
    protected $table = TABLE_CONFIGURATION;
    protected $primaryKey = 'configuration_id';
    public $timestamps = false;
    protected $guarded = ['configuration_id'];

    // @todo relocate to service class
    public function loadConfigSettings()
    {
        $configs = self::all();
        foreach ($configs as $config) {
            $configValue = $config['configuration_value'];
            if (in_array($config['configuration_group_id'], [2,3])) {
                $configValue = (int)$configValue;
            }
            define(strtoupper($config['configuration_key']), $configValue);
        }
    }
}
