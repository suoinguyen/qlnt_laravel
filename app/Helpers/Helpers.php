<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helpers {

    public static function getSetting($key, $default_value = '') {
        $setting = DB::table('settings')->where('key', $key)->first();
        if (!$setting) return false;

        if (isset($setting->value)){
            $value = $setting->value;
        }else{
            $value = $default_value;
        }

        return $value;
    }

    public static function getSettings() {
        $settings = DB::table('settings')->get();
        $sett_arr = array();
        foreach ($settings as $setting){
            $sett_arr[$setting->key] = $setting->value;
        }

        return $sett_arr;
    }
}
