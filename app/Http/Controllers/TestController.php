<?php

namespace App\Http\Controllers;

use App\Classes\ImageCompare;
use App\Classes\RegEx\RegEx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Classes\TrademarkSearch;
use App\Jobs\CreatePeriodicReport;
use App\Jobs\CheckOfficialBulletin;
use App\Models\Bulletin;
use App\Models\Keyword;
use App\Models\Media;
use App\Models\Trademark;
use App\Models\Report;
use App\Models\TestLimit;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Classes\Bulletin as BulletinClass;

class TestController extends Controller
{
    /**
     * Test
     *
     * @return void
     */
    public function test(Request $request)
    {
        // $users = User::get();
        // foreach($users as $user){
        //     CreatePeriodicReport::dispatch($user);
        // }
        // return "lets go";
    }

    /**
     * Share last 5 bulletins for views
     *
     * @return void
     */
    public function __construct()
    {
        if (Cache::has('last5bulletin')) {
            $bulletins = Cache::get('last5bulletin');
        } else {
            $bulletins = Media::where('is_official', 1)->where('is_saved', 1)->orderBy('bulletin_no', 'desc')->take(5)->get();
            Cache::put('last5bulletin', $bulletins);
        }

        view()->share('last5bulletin', $bulletins);
    }
    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        $bulletins = Media::where('is_official', 1)->where('is_saved', 1)->latest()->take(5)->get();
        return view('dashboard.pages.search')->with('bulletins', $bulletins);
    }

    public function landscapeSearch()
    {
        $user_plan = Auth::user()->plan_id;
        // if user doesn't have the free plan
        if ($user_plan != 1) {
            $bulletins = Media::where('is_official', 1)->where('is_saved', 1)->latest()->get();
            return view('dashboard.pages.landscape-search')->with('bulletins', $bulletins);
            //user has the free plan
        } else {
            return to_route('subscription.list');
        }
    }

    /**
     * Trademark Search
     *
     * @param  mixed $request
     * @return array
     */
    public function trademarkSearch(Request $request)
    {

        $exactMatchCharacterCount = substr_count($request->keyword, '"');

        $exclusion_keywords = json_decode($request->exclusion_keywords, true);
        if ($exclusion_keywords != null) {
            // get only value
            $exclusion_keywords = array_column($exclusion_keywords, 'value');
            if (count($exclusion_keywords) > 10) {
                // get first 10
                $exclusion_keywords = array_slice($exclusion_keywords, 0, 10);
            }
        }

        if ($exactMatchCharacterCount > 0 && $exactMatchCharacterCount != 2) {
            return redirect()->back()->withErrors(['keyword' => 'Lütfen arama yaparken tırnak işareti(") kullanımını doğru bir şekilde yapınız.']);
        }

        $search = new TrademarkSearch();

        $user = auth()->user();
        if (!$user->hasRole('user')) {
            // return abort(403, 'You are not authorized to access this page');
        }

        // Bulletins used in search

        $bulletin = $request->input('bulletins');

        // Get cached trademarks
        if ($bulletin == null) {
            $bulletin = Media::where('is_official', 1)->where('is_saved', 1)->orderBy('bulletin_no', 'desc')->latest()->take(5)->get();
        }
        $trademarks = $search->getCachedTrademarks($bulletin, 'trademark-search');

        // Timer Start
        $start = microtime(true);

        // Searched classes
        // $searchedClasses = $search->getExplodedData($request->input('classes'), ',');
        $searchedClasses = $request->input('classes') ?? [];
        // array string to int

        // Convert keyword to lowercase
        $keyword['string'] = $search->str2lower($request->input('keyword'));

        function checkStringFormat($string)
        {
            $str_arr = str_split($string);
            for ($i = 0; $i < count($str_arr) - 1; $i += 2) {
                if ($str_arr[$i + 1] != ' ') {
                    return false;
                }
            }
            return true;
        }

        function checkStrinFormatDotted($string)
        {
            $str_arr = str_split($string);
            for ($i = 0; $i < count($str_arr) - 1; $i += 2) {
                if ($str_arr[$i + 1] != '.') {
                    return false;
                }
            }
            return true;
        }

        // Break down keyword word by word
        $keyword['fragments'] = $search->getExplodedData($keyword['string'], ' ');
        // $trademark = [
        //     'name' => 'suppilulima'
        // ];
        // dd($keyword['fragments']);

        // Filter bulletins.

        // $response = $search->searchWithRegex($keyword, $trademark, $searchedClasses, $search, $exclusion_keywords);

        // return $response;

        $filteredTrademarks = $search->filteredTrademarks($trademarks, $searchedClasses, $keyword, $search, $exclusion_keywords);
        // Timer End
        $end = microtime(true);

        // Respond to the matching trademarks.
        if ($request->input('bulletins') == null) {
            $user->decrement('remaining_landscape_search_limit');
            $filteredTrademarks = collect($filteredTrademarks);
            $number_of_results = count($filteredTrademarks);

            return view('dashboard.pages.landscape-search')
                ->with('filteredTrademarks', $filteredTrademarks)
                ->with('number_of_results', $number_of_results)
                ->with('SearchedBulletin', $bulletin)
                ->with('keyword', $request->input('keyword'))
                ->with('classes', $request->input('classes'))
                ->with('exclusion_keywords', $request->input('exclusion_keywords'))
                ->with('time', $end - $start);
        } else {
            $user->decrement('remaining_bulletin_search_limit');
            return view('dashboard.pages.search')
                ->with('filteredTrademarks', $filteredTrademarks)
                ->with('SearchedBulletin', $bulletin)
                ->with('keyword', $request->input('keyword'))
                ->with('classes', $request->input('classes'))
                ->with('exclusion_keywords', $request->input('exclusion_keywords'))
                ->with('time', $end - $start);
        }
    }



    /**
     * Reverse search test
     *
     * @return void
     */
    public function reverseTest()
    {
        return "Reverse test";
    }
}
