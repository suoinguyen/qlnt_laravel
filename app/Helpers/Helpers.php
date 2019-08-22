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

    public static function validateDateTime($date_str, $format) {
        date_default_timezone_set('UTC');
        $date = \DateTime::createFromFormat($format, $date_str);
        return $date && ($date->format($format) === $date_str);
    }

    public static function calcTotalDay($start_date, $end_date, $format = 'd/m/Y'){
        if (!$end_date || !$end_date){
            return false;
        }

        //Check date format
        $check  = true;
        $start_date_check = self::validateDateTime($start_date, $format);
        $end_date_check = self::validateDateTime($end_date, $format);
        if (!$start_date_check || !$end_date_check){
            $check = false;
        }

        if (!$check){
            return false;
        }

        $start = \DateTime::createFromFormat($format, $start_date);
        $start_day = $start->format('d');
        $start_month = $start->format('m');
        $start_year = $start->format('Y');

        $end = \DateTime::createFromFormat($format, $end_date);
        $end_day = $end->format('d');
        $end_month = $end->format('m');
        $end_year = $end->format('Y');

        $total_year = (int) $end_year - (int) $start_year;
        $day_per_year = $total_year * 12 * 30; //1 nam co 12 thang, 1 thang 30 ngay
        $total_month = (int) $end_month - (int) $start_month;
        $day_per_month = $total_month * 30; //1 thang 30 ngay
        $day_per_day = (int) $end_day - (int) $start_day;

        $total = $day_per_year + $day_per_month + $day_per_day;
        return $total;
    }

}
