<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        try {
            $value = DB::table('settings')->where('key', $key)->value('value');
            return $value !== null ? $value : $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}
