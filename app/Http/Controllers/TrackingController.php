<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
         // Secret key check
         if ($request->secret_key != env('SECRET_KEY')) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 401);
        }
        $data = [];
        // Server-database status check
        try {
            DB::connection()->getPdo();
            $dbStatus = true;
        } catch (\Exception $e) {
            $dbStatus = false;
        }

        // Return response
        return response()->json([
            'message' => 'success',
            'serverStatus' => true,
            'dbStatus' => $dbStatus,
        ], 200);
    }
}
