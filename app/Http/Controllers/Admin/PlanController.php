<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\TestLimit;
use App\Models\User;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::all();
        return view('dashboard.admin.plans.index', compact('plans'));
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
        $request->validate([
            'plan_name' => 'required',
            'keyword_limit' => 'required',
            'search_limit' => 'required',
        ]);
        $plan = Plan::updateOrCreate([
            'plan_name' => $request->plan_name,
            'keyword_limit' => $request->keyword_limit,
            'search_limit' => $request->search_limit,
        ]);
        if ($plan->exists) {
            return response()->json(['success' => true]);
        }
        else {
            return response()->json(['error' => true]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function SearchUpdate(Request $request, Plan $search_plan)
    {
        if($request->ajax()) {
            if ($request->value >= 0) {
                $search_plan = Plan::find($request->pk);

                $old_plan_search_limit =  $search_plan->search_limit;
                $search_plan->update([
                    'search_limit' => $request->value
                ]);
                $users = User::where('plan_id',$search_plan->id)->get();


                foreach ($users as $user) // update foreach user the search limit when changing the search limit of the plan
                {
                    $search_limit = TestLimit::where('user_id',$user->id)->first();

                    if(!is_null($search_limit)) {
                        if($search_limit->limit === $old_plan_search_limit) {
                            $search_limit = TestLimit::where('user_id',$user->id);
                            $search_limit->update([
                                'limit' => $request->value
                            ]);
                        }
                    }
                }
            }
            else {
                return response()->json(['error' => 'Limit değeri 0'], 422);
            }
        }
        return response()->json(['success' => true]);

    }

    public function KeywordLimit(Request $request, Plan $keyword_plan)
    {
        if($request->ajax()) {
            if ($request->value >0) {
                $keyword_plan = Plan::find($request->pk);

                $old_plan_keyword_limit = $keyword_plan->keyword_limit; //old keyword limit

                $keyword_plan->update ([
                    'keyword_limit' => $request->value
                ]);

                $user = User::where('plan_id',$keyword_plan->id)->first();

                if($user->keyword_limit === $old_plan_keyword_limit) {
                    $user = User::where('plan_id',$keyword_plan->id);
                    $user->update([
                        'keyword_limit' => $request->value
                    ]);
                }

            }
            else {
                return response()->json(['error' => 'Limit değeri 0'], 422);
            }
        }
        return response()->json(['success' => true]);
    }

    public function PlanName(Request $request, Plan $plan_name)
    {
        if($request->ajax()) {
            if($request->value !='') {
                $plan_name = Plan::find($request->pk);
                $plan_name->update ([
                    'plan_name' => $request->value
                ]);
            }
            else {
                return response()->json(['error' => 'plan adı alanı boş olamaz '], 422);
            }
        }
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {

        $user_has_plan = User::where('plan_id',$plan->id)->count();
        if($user_has_plan == 0 )
        {
            $plan->delete();
            return redirect()->route('plans.index');
        }
        else {
            return redirect()->back()->with('error', 'Bir veya daha fazla kullanıcı bu plana sahip, silemezsiniz');
        }
    }
}
