<?php

namespace App\Http\Controllers;

use App\Models\Media;

class BulletinController extends Controller
{
    /**
     * Get bulletin from TURKPATENT.
     *
     * @return void
     */
    public function index()
    {
        $bulletins = Media::where('is_official',true)->get();
        $bulletins = $bulletins->sortByDesc('bulletin_no');

        return view('dashboard.admin.bulletins.index',compact('bulletins'));
    }

    /**
     * Get official bulletins.
     *
     * @return void
     */
    public function official()
    {
        $bulletins = Media::where('is_official',true)->get();
        return view('dashboard.bulletin.official',compact('bulletins'));
    }
}
