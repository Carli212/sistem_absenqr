<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class LogActivity
{
    public static function add($data)
    {
        ActivityLog::create([
            'user_id'    => $data['user_id'] ?? null,
            'activity'   => $data['activity'],
            'description'=> $data['description'] ?? null,
            'ip'         => request()->ip(),
            'device_id'  => session('device_id'),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
