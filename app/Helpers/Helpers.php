<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public static function dateSave($value_save, $current_format = 'd/m/Y', $format_save = 'Y-m-d'){
        $date = Carbon::createFromFormat($current_format, $value_save);
        return $date->format($format_save);
    }

    public static function dateShow($value, $current_format = 'Y-m-d', $format_show = 'd/m/Y'){
        $date = Carbon::createFromFormat($current_format, $value);
        return $date->format($format_show);
    }
}
