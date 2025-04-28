<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get some basic stats for the dashboard
        $stats = [
            'total_users' => User::where('role_id', 2)->count(),
            'new_users_today' => User::where('role_id', 2)
                ->whereDate('created_at', today())
                ->count(),
            'active_users' => DB::table('sessions')
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count(),
        ];
        
        // Get latest users
        $latest_users = User::where('role_id', 2)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard.index', compact('stats', 'latest_users'));
    }
}
