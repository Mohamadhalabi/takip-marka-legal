<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourController extends Controller
{    
    /**
     * Update the specified tour page
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {
        $page = $request->page;
        if($page == 'dashboard') auth()->user()->tour->dashboard = false;
        else if($page == 'report') auth()->user()->tour->report = false;
        else if($page == 'keyword') auth()->user()->tour->keyword = false;
        if(auth()->user()->tour->save()){
            return response()->json(['success' => true]);
        }
        else return response()->json(['success' => false]);
    }

    /**
     * Update all tour pages
     *
     * @param  mixed $request
     * @return void
     */
    public function updateAll(Request $request)
    {
        auth()->user()->tour->dashboard = true;
        auth()->user()->tour->report = true;
        auth()->user()->tour->keyword = true;
        if(auth()->user()->tour->save()){
            return response()->json(['success' => true]);
        }
        else return response()->json(['success' => false]);
    }
}
