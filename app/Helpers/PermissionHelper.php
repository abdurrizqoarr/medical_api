<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function checkPermissionOrAbort($permission)
    {
        if (!Auth::user() || !Auth::user()->can($permission)) {
            abort(403, 'Tidak memiliki izin: ' . $permission);
        }
    }
}
