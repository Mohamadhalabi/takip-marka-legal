<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $first_day_of_next_month = Carbon::now()->startOfMonth()->addMonth()->format('d-m-Y'); // first day of next month
        $startDate=Carbon::now()->firstOfMonth()->addDays(14)->format('d-m-Y'); //15 of each month
        $today = Carbon::now()->format('d-m-Y');

        $result = Carbon::parse($startDate)->lte(Carbon::parse($today));
        if($result){
            $result = $first_day_of_next_month;
        }
        else{
            $result = $startDate;
        }
        $keywords = \auth()->user()->keywords;
        if($keywords->isEmpty()){
            $user_has_no_keywords = true;
        }
        else{
            $user_has_no_keywords = false;
        }
        $reports = Report::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(10);
        $layercount = count($reports);

        $lastreport = Report::where('user_id','=',Auth::id())->orderBy('created_at','desc')->get('created_at')->first();
        return view('dashboard.pages.report.index',compact('reports','lastreport','result','user_has_no_keywords','layercount'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang,$id)
    {
        $report = Report::find($id);

        if($report == null){
            return redirect('/tr/dashboard/report')->with('error','Bu raporu şu anda görüntüleyemiyorsunuz. Lütfen daha sonra tekrar deneyin.');
        }

        if($report->user_id == Auth::id() || Auth::user()->hasRole('admin'))
        {
            $json = Storage::disk('reports')->get($report->path);
            if(!$json){
                return redirect('/tr/dashboard/report')->with('error','Bu raporu şu anda görüntüleyemiyorsunuz. Lütfen daha sonra tekrar deneyin.');
            }
            $json = json_decode($json, true);
            foreach($json['bulletins'] as $key => $bulletin)
            {
                $media = Media::where('bulletin_no',substr($bulletin['name'],0,3))->first();
                $json['bulletins'][$key]['created_at'] = $media->created_at ?? null;
                $json['bulletins'][$key]['bulletin_no'] = $media->bulletin_no ?? null;;
            }

            $keywords = [];
            foreach($json['reports'] as $key => $keyword){
                $keywords[] = $keyword['keyword'];
            }

            $data = [];
            $counter = 0;
            foreach($json['reports'] as $key => $keyword){
                $counter += count($keyword['keyword']['trademarks']);
            }
            $data['match_count'] = $counter;

            return view('dashboard.pages.report.show',compact('json','report','data'));
        }

        return redirect()->route('report.index')->with('error','Bu raporu görüntüleme yetkiniz yok.');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
