<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;

class DashboardController extends Controller
{    
    /**
     * /dashboard route with user activities
     *
     * @return void
     */
    public function index()
    {
        $userActivity = UserActivity::where('user_id', auth()->user()->id)->latest()->paginate(10);
        return view('dashboard.index', compact('userActivity'));
    }
}
