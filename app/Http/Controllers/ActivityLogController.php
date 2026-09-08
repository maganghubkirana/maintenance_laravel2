<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        // Filter berdasarkan modul (opsional)
        if ($request->has('module') && $request->module != '') {
            $query->where('log_name', $request->module);
        }

        $logs = $query->paginate(15);

        return view('activity_logs.index', compact('logs'));
    }
}
