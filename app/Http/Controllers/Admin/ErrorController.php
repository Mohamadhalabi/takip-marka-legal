<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Error;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $errors = Error::all();
        return view('dashboard.pages.error.index', compact('errors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Error  $error
     * @return \Illuminate\Http\Response
     */
    public function show(Error $error)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Error  $error
     * @return \Illuminate\Http\Response
     */
    public function edit(Error $error)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Error  $error
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Error $error)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Error  $error
     * @return \Illuminate\Http\Response
     */
    public function destroy(Error $error)
    {
        //
    }
}
