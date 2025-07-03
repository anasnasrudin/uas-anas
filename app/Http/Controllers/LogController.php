<?php

namespace App\Http\Controllers;

use App\Models\TableLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function log_activity(Request $request){
        $l = TableLog::with('user');

        if ($request->filled('tanggal')) {
            $l = $l->whereDate('created_at', $request->tanggal);
        }

        return view('admin.log-activity', [
            'data_log' => $l->orderBy('created_at', 'desc')->paginate(5),
            'tanggal' => $request->tanggal
        ]);
    }
}
