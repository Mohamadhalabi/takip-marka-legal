<?php

namespace App\Http\Controllers;

use App\Classes\TrademarkSearch;
use App\Models\Keyword;
use App\Models\Plan;
use App\Models\TestLimit;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('dashboard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return redirect()->route('dashboard.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keywords = Keyword::where('user_id', Auth::user()->id)->paginate(10);
        $remaining_keywords = TestLimit::where('user_id',Auth::user()->id)->first()->keyword_limit;
        return view('dashboard.pages.keyword.create', compact('keywords','remaining_keywords'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $keywords = Keyword::where('user_id', $user->id)->get();

        if (count($keywords) < $user->keyword_limit) {
            $this->validate($request, [
                'keyword' => 'required',
            ]);

            $exclusion_keywords = json_decode($request->exclusion_keywords, true);
            if ($exclusion_keywords != null) {
                // get only value
                $exclusion_keywords = array_column($exclusion_keywords, 'value');
                if (count($exclusion_keywords) >  10) {
                    // get first 10
                    $exclusion_keywords = array_slice($exclusion_keywords, 0, 10);
                }
            }
            // Check if keyword is already exist
            if ($keywords->where('keyword', $request->keyword)->count() > 0) {
                return redirect()->back()->with('error', trans('keyword-message.keyword-already-exists'));
            }
            $search = new TrademarkSearch();
            $keyword = new Keyword();
            $keyword->user_id = Auth::user()->id;
            $keyword->keyword = $request->keyword;
            $keyword->classes = $request->classes;
            $keyword->slug = Str::slug($request->keyword);
            $keyword->exclusion_keywords = $exclusion_keywords ? json_encode($exclusion_keywords) : null;
            $keyword->keyword_lower = $search->str2lower($request->keyword);
            $keyword->keyword_fragments = $search->getExplodedData($request->keyword_lower);
            $keyword->save();


            UserActivity::create([
                'user_id' => Auth::user()->id,
                'event' => __('theme/dashboard.keyword-added'),
                'data' => $request->keyword
            ]);
            return redirect()->route('keyword.create', ['language' => app()->getLocale()])->with('success', trans('keyword-message.keyword-successfully-added'));
        }
        return redirect()->route('keyword.create', ['language' => app()->getLocale()])->with('error', trans('keyword-message.you-have-exceeded-the-max-numb-of-keywords'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function edit($language, Keyword $keyword)
    {
        $keyword->exclusion_keywords = json_decode($keyword->exclusion_keywords, true);

        if ($keyword->user_id == Auth::user()->id) {
            return view('dashboard.pages.keyword.edit', compact('keyword'));
        } else {
            return redirect()->route('keyword.create')->with('error', trans('keyword-message.you-dont-have-permission-to-edit-this-keyword'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, Keyword $keyword)
    {
        $this->validate($request, [
            'keyword' => 'required',
        ]);
//        'event' => __('theme/dashboard.keyword-deleted'),

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'event' => __('theme/dashboard.keyword-updated'),
            'data' => $request->keyword,
            'old_data' => $keyword->keyword,
        ]);

        $exclusion_keywords = json_decode($request->exclusion_keywords, true);
        if ($exclusion_keywords != null) {
            $keyword->exclusion_keywords = json_encode($exclusion_keywords);
            // get only value
            $exclusion_keywords = array_column($exclusion_keywords, 'value');
            if (count($exclusion_keywords) >  10) {
                // get first 10
                $exclusion_keywords = array_slice($exclusion_keywords, 0, 10);
            }
        }
        $keyword->keyword = $request->keyword;
        $keyword->classes = $request->classes;
        $keyword->slug = Str::slug($request->keyword);
        $keyword->save();


        return redirect()->route('keyword.create', ['language' => app()->getLocale()])
            ->with('success', trans('keyword-message.keyword-updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, Keyword $keyword)
    {
        $user = Auth::user(); // Authenticated user
        $keywords = $user->keywords; // Auth user keywords
        $user_plan_limit = Plan::where('id',$user->plan_id)->first()->keyword_limit; // user's plan keyword limit

        $keyword->delete();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'event' => __('theme/dashboard.keyword-deleted'),
            'data' => $keyword->keyword
        ]);
        return redirect()->route('keyword.create', ['language' => app()->getLocale()])
            ->with('success', trans('keyword-message.keyword-deleted-successfully'));
    }

    public function search(Request $request)
    {
        $filter_keyword = $request->filter_keyword ?? null;
        $filter_class = $request->filter_class ?? null;

        if ($filter_keyword != null && $filter_class != null) {
            $keywords = Keyword::where('user_id', Auth::user()->id)->where('keyword', 'like', '%' . $filter_keyword . '%')->where(function ($query) use ($filter_class) {
                $query->where('classes', 'like', '%' . $filter_class . '%');
            })->paginate(10);
        } elseif ($filter_keyword != null) {
            $keywords = Keyword::where('user_id', Auth::user()->id)->where('keyword', 'like', '%' . $filter_keyword . '%')->paginate(10);
        } elseif ($filter_class != null) {
            $keywords = Keyword::where('user_id', Auth::user()->id)->where(function ($query) use ($filter_class) {
                $query->where('classes', 'like', '%' . $filter_class . '%');
            })->paginate(10);
        } else {
            $keywords = Keyword::where('user_id', Auth::user()->id)->paginate(10);
        }

        return view('dashboard.pages.keyword.create', compact('keywords', 'filter_keyword', 'filter_class'));
    }
}
