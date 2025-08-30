<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

if (! function_exists('recordActivity')) {
    function recordActivity($action, $description = null)
    {
        ActivityLog::create([
            'user_id'    => Auth::check() ? Auth::id() : null,
            'action'     => $action,
            'description'=> $description,
        ]);
    }
}
