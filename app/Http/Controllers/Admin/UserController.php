<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Error;
use App\Models\Keyword;
use App\Models\Plan;
use App\Models\TestLimit;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\KeywordsImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereNot('id', auth()->user()->id)->get();

        $plans = Plan::all();
        return view('dashboard.admin.users.index', compact('users','plans'));
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
        $currentURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $path = parse_url($currentURL, PHP_URL_PATH);
        $segments = explode('/', $path);
        $lastSegment = end($segments);

        $user = User::where('id',$lastSegment)->first();
        return view('dashboard.admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->ajax()) {
            if($request->value >=0) {
                $user = User::find($request->pk);
                // Update test limit

                $custom_plan = Plan::where('plan_name','like','%'.'Özel'.'%')->first();
                if($custom_plan != null) {
                    $user->update([
                        'plan_id' => $custom_plan->id
                    ]);
                    $user->testLimit()->update([
                        'limit' => $request->value
                    ]);
                    User::where('id',$request->pk)->update([
                        'search_limit' => $request->value,
                        'plan_id' => $custom_plan->id
                    ]);
                }
                else {
                    $user->testLimit()->update([
                        'limit' => $request->value
                    ]);
                    User::where('id',$request->pk)->update([
                        'search_limit' => $request->value
                    ]);
                }
            }
            else{
                return response()->json(['error' => "Limit değeri 0'dan büyük olmalıdır."], 422);
            }
            return response()->json(['success' => true]);
        }
    }

    public function keywordUpdate(Request $request, User $user)
    {
        if ($request->ajax()) {
            if($request->value >=0) {
                $user = User::find($request->pk);
                // Update test limit
                $custom_plan = Plan::where('plan_name','like','%'.'Özel'.'%')->first();
                if($custom_plan != null) {
                    $user->update([
                        'keyword_limit' => $request->value,
                        'plan_id' => $custom_plan->id
                    ]);
                    $user->testLimit()->update([
                        'keyword_limit' => $request->value
                    ]);
                }
                else {
                    $user->update([
                        'keyword_limit' => $request->value,
                    ]);
                    $user->testLimit()->update([
                        'keyword_limit' => $request->value
                    ]);
                }
            }
            else{
                return response()->json(['error' => "Limit değeri 0'dan büyük olmalıdır."], 422);
            }
            return response()->json(['success' => true]);
        }
    }

    public function landscapeUpdate(Request $request, User $user)
    {
        if ($request->ajax()) {
            if($request->value >=0) {
                $user = User::find($request->pk);
                // Update test limit

                $custom_plan = Plan::where('plan_name','like','%'.'Özel'.'%')->first();
                if($custom_plan != null) {
                    $user->update([
                        'plan_id' => $custom_plan->id
                    ]);
                    $user->testLimit()->update([
                        'landscape_limit' => $request->value
                    ]);
                    User::where('id',$request->pk)->update([
                        'landscape_limit' => $request->value,
                        'plan_id' => $custom_plan->id
                    ]);
                }
                else {
                    $user->testLimit()->update([
                        'landscape_limit' => $request->value
                    ]);
                    User::where('id',$request->pk)->update([
                        'landscape_limit' => $request->value
                    ]);
                }
            }
            else{
                return response()->json(['error' => "Limit değeri 0'dan büyük olmalıdır."], 422);
            }
            return response()->json(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $reports = $user->reports;
        foreach ($reports as $report) {
            if (Storage::disk('reports')->exists($report->path)) {
                $path = Storage::disk('reports')->path($report->path);
                unlink($path);
            }
            $report->delete();
        }
        $keywords = $user->keywords;
        foreach ($keywords as $keyword) {
            $keyword->delete();
        }

        TestLimit::where('user_id', $user->id)->delete();
        Tour::where('user_id', $user->id)->delete();
        Error::where('user_id', $user->id)->delete();

        $user->delete();

        return redirect()->route('user.index');
    }

    public function planUpdate(Request $request, User $user)
    {
        if($request->ajax())
        {
            $user_id = $request->user_id;
            $user = User::find($user_id);

            $old_plan = Plan::where('id',$user->plan_id)->first();
            $user->update([
                'plan_id' => $request->plan
            ]);
            if($user->wasChanged()) {
                $new_limit = Plan::where('id',$request->plan)->first();

                $search = TestLimit::where('user_id',$user_id)->first();

                $search->update([
                    'limit' => $new_limit->search_limit,
                    'landscape_limit' => $new_limit->landscape_limit,
                    'keyword_limit' => $new_limit ->keyword_limit,
                ]);
                $user->update([
                    'keyword_limit' => $new_limit->keyword_limit,
                    'landscape_limit' => $new_limit->landscape_limit,
                    'search_limit' => $new_limit->search_limit
                ]);
            }
        }
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    /**
     */
    public function import($id, Request $request)
    {
        $keyword_count_before = Keyword::where('user_id',$id)->get();

        $validator = Validator::make($request->all(), [ // <---
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);


        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        Excel::import(new KeywordsImport($id),request()->file('file'));

        $keyword_count_after = Keyword::where('user_id',$id)->get();



        if($keyword_count_after->count() > $keyword_count_before->count()) {
            $number_of_new_keywords =  $keyword_count_after->count() - $keyword_count_before->count();
            return redirect()->back()->with('success', $number_of_new_keywords." anahtar kelime eklendi" );
        }
        if($keyword_count_after->count() == $keyword_count_before->count()) {
            return redirect()->back()->with('info', '0 anahtar kelime eklendi' );
        }
        else {
            return redirect()->back()->with('error', 'Bir hata oluştu' );
        }
    }
}
