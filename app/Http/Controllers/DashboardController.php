<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Sop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalSops = Sop::count();
            $totalOpds = Opd::count();
        } else {
            $totalUsers = null; // user biasa tidak melihat
            $totalSops = Sop::where('user_id', $user->id)->count();
            $totalOpds = null;
        }

        return view('dashboard', compact('totalUsers', 'totalSops', 'totalOpds'));
    }
}
