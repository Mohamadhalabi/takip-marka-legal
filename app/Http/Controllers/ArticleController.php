<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::get();

        return view('dashboard.admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article();

        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->description = $request->description;
        $article->body = $request->content;
        $article->language = $request->language;
        $article->is_published = ($request->is_published == 'on') ? 1 : 0;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('/article-images'), $filename);
            $article->image = $filename;
        }

        $article->save();

        return redirect()->route('articles.index', ['language' => app()->getLocale()])->with('success', 'Article created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('dashboard.admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit($lang = "en", Article $article)
    {
        return view('dashboard.admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update($lang = "en", Request $request, Article $article)
    {
        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->body = $request->content;
        $article->description = $request->description;
        $article->language = $request->language;
        $article->is_published = ($request->is_published == 'on') ? 1 : 0;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('/article-images'), $filename);
            $article->image = $filename;
        }
        $article->save();

        return redirect()->route('articles.index', ['language' => app()->getLocale()])->with('success', 'Article updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang = "en", Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index', ['language' => app()->getLocale()])->with('success', 'Article deleted successfully');
    }
}
