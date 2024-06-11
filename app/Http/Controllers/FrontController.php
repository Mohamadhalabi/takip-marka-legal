<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index($lang = null)
    {
        $articles = Article::where([
            'is_published' => 1,
            'language' => app()->getLocale()
        ])->take(5)->get();

        return view('index', compact('articles'));
    }

    public function articles()
    {
        $articles = Article::where([
            'is_published' => 1,
            'language' => app()->getLocale()
        ])->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function article(Request $request)
    {
        $article = Article::where('slug', request()->slug)->first();

        if (!$article) {
            abort(404);
        }

        return view('articles.show', compact('article'));
    }
}
