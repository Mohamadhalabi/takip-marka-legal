<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $articles = Article::where('is_published', 1)->get();
        return response()->view('sitemap', compact('articles'))->header('Content-Type', 'text/xml');
    }
}
