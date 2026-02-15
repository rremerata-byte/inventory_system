<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index()
    {
        $logs = ActivityLog::with('user')->latest('logged_at')->paginate(30);
        return view('logs.index', compact('logs'));
    }
}
