<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function index($language = 'tr')
    {
        if($language == null) {
            App::setLocale('tr');
        }else{
            App::setLocale($language);

        }
        return view('welcome');
    }
}
