<?php

namespace App\Jobs;

use App\Classes\ImageCompare;
use App\Classes\TrademarkSearch;
use App\Models\Bulletin;
use App\Models\Keyword;
use App\Models\Media;
use App\Models\Plan;
use App\Models\Report;
use App\Models\TestLimit;
use App\Models\Trademark;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Throwable;

class CreatePeriodicReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // set timeout to 5 hours
        set_time_limit(18000);
        ini_set('memory_limit', '512M');
        $user = $this->user;
        $userImages = $user->images()->where('history', false)->get();

        $search = new TrademarkSearch();

        Log::channel('monitor')->info('Report queue started. User: ' . $user->name);

        // Cache last report date
        $bulletins = Media::where('bulletin_no', 436)
            ->get();

        // Create report array.
        $report = array();
        $report["bulletins"] = $bulletins;
        // $keywords = Keyword::get();
        $keywords = $user->keywords;
        $subscription = $user->subscription ?? 1;
        // If the user does not have a keyword it won't generate a report.
        if ($keywords->count()) {

            //Get the user plan keyword limit
            $user_plan_limit = Plan::where('id', $user->plan_id)->first()->keyword_limit;

            // Compare the plan's keyword limit to the number of keywords of the user
            // if ($keywords->count() > $user_plan_limit) {
            //     //if the keywords counter is greater than the plan's limit => we get the first equal to the plan limit
            //     $keywords = $keywords->slice(0, $user_plan_limit);
            //     $keywords->toArray();
            // }

            $report['user'] = $user;
            $report["bulletins"] = $bulletins;
            $report['created_at'] = Carbon::now();

            // Calculation of how much trademark in the bulletin and bulletins id.
            $bulletins_id = array();
            $total = 0;
            foreach ($bulletins as $bulletin) {
                $total += $bulletin->total;
                $bulletins_id[] = $bulletin->id;
            }
            $report['totalTrademark'] = $total;

            // If there is a bulletin to query, continue processing.
            if (count($report['bulletins']) > 0) {
                // Add all user-owned keywords and trademarks matching that keyword to the report.
                $c = 1;
                $trademarks = Trademark::whereIn('bulletin_id', $bulletins_id)->get();
                foreach ($keywords->take(500) as $key => $keyword) {
                    $searchedClasses = $keyword->classes ?? [];

                    // $keyword['string'] = $keyword->keyword_lower;
                    // $keyword['fragments'] = $keyword->keyword_fragments;
                    // Convert keyword to lowercase
                    $keyword['string'] = $search->str2lower($keyword->keyword);
                    // Break down keyword word by word
                    $keyword['fragments'] = $search->getExplodedData($keyword['string'], ' ');
                    preg_match('/"([^"]*)"/', $keyword['string'], $matches);
                    $exatchMatch = isset($matches[1]) ? $matches[1] : null;
                    $test = json_decode($keyword->exclusion_keywords, true);
                    // $keyword->exclusion_keywords; değerindeki tüm kelimeleri , ile birleştir
                    try {
                        $exclusionKeywordsArray = json_decode($keyword->exclusion_keywords, true);
                        $exclusionKeywords = implode(' -', $exclusionKeywordsArray);
                    } catch (\Throwable $th) {
                        $exclusionKeywords = '';
                    }
                    // Filter bulletins.
                    $keyword['exclusion_keywords'] = $exclusionKeywords;
                    $keyword['exatchMatch'] = $exatchMatch;
                    $keyword['filtered_classes'] = implode(',', $searchedClasses);
                    // Filter bulletins.
                    $filteredTrademarks = $search->filteredTrademarks($trademarks, $searchedClasses, $keyword, $search, $test);

                    $report['reports'][$key]['keyword'] = $keyword;
                    $report['reports'][$key]['keyword']['trademarks'] = $filteredTrademarks;
                    Log::channel('debug')->info('Report queue keyword ' . $c . ' : ' . $keyword->keyword);
                    // $keywords içerisinden $keyword sil
                    $keywords->forget($key);
                    $c++;
                }
                $imageCompare = new ImageCompare();
                // filter trademarks
                $filteredTrademarks = Trademark::where('bulletin_id', 1714)->whereNotNull([
                    'dominant_colors', 'phash', 'histogram'
                ])->get();

                foreach ($userImages as $userImage) {
                    $image_colors = json_decode($userImage->dominant_colors);
                    $userImage->dominant_colors = $image_colors;
                    $phash_arr = [];
                    $histogram_arr = [];
                    $dominant_colors_arr = [];
                    foreach ($filteredTrademarks as $trademark) {
                        try {
                            $trademark_colors = json_decode($trademark->dominant_colors);
                        } catch (\Throwable $th) {
                        }
                        $trademark->dominant_colors = $trademark_colors;

                        // phash similarity
                        $phash_similarity = $imageCompare->phashSimilarity($userImage, $trademark);
                        $phash_arr = array_slice($phash_arr, 0, 5);
                        // histogram similarity
                        $histogram_similarity = $imageCompare->histogramSimilarity($userImage, $trademark);
                        $histogram_arr = array_slice($histogram_arr, 0, 5);
                        // dominant colors similarity
                        $dominant_colors_arr = array_slice($dominant_colors_arr, 0, 5);
                        $dominant_colors_similarity = $imageCompare->colorSimilarity($userImage, $trademark);

                        // $trademark->histogram_decoded i kaldır
                        unset($trademark->histogram_decoded);
                        // diziyi güncelle
                        $phash_arr[] = [
                            'similarity' => $phash_similarity,
                            'trademark' => $trademark,
                        ];

                        $histogram_arr[] = [
                            'similarity' => $histogram_similarity,
                            'trademark' => $trademark,
                        ];

                        $dominant_colors_arr[] = [
                            'similarity' => $dominant_colors_similarity,
                            'trademark' => $trademark,
                        ];


                        // her seferinde en yüksek $phash_similarity değerlerini içerecek şekilde diziyi yeniden sırala
                        usort($phash_arr, function ($a, $b) {
                            return $a['similarity'] < $b['similarity'];
                        });

                        usort($histogram_arr, function ($a, $b) {
                            return $a['similarity'] < $b['similarity'];
                        });

                        usort($dominant_colors_arr, function ($a, $b) {
                            return $a['similarity'] < $b['similarity'];
                        });

                        unset($filteredTrademarks[$trademark->id]);
                    }
                    $similarities['phash'] = $phash_arr;
                    $similarities['histogram'] = $histogram_arr;
                    $similarities['dominant_colors'] = $dominant_colors_arr;

                    unset($userImage->histogram_decoded);
                    $userImage->similarities = $similarities;
                }
                $report['userImages'] = $userImages;

                unset($trademarks);

                // Save the resulting report array as json file.
                $fileName = Str::slug($user->name) . '_' . $user->id . '_' . Carbon::now()->format('Y-m-d') . '_' . Carbon::now()->format('H-i-s') . '.json';
                $pdfName = Str::slug($user->name) . '_' . $user->id . '_' . Carbon::now()->format('Y-m-d') . '_' . Carbon::now()->format('H-i-s') . '.pdf';
                Storage::disk('reports')->put($fileName, json_encode($report));
                // Create new report
                $report = Report::create([
                    'user_id' => $user->id,
                    'path' => $fileName,
                    'pdf' => $pdfName,
                ]);

                // Refill search limit if the test limit is less than plan search limit
                $plan = Plan::where('id', $user->plan_id)->first();
                $testlimit = TestLimit::where('user_id', $user->id)->first();
                if ($testlimit->limit < $plan->search_limit) {
                    $testlimit->update([
                        'limit' => $plan->search_limit
                    ]);
                }

                // Reads the resulting report file and converts it to JSON object.
                $json = Storage::disk('reports')->get($report->path);
                $json = json_decode($json, true);

                foreach ($json['bulletins'] as $json_date) {
                    $item[] = Bulletin::where('id', '=', $json_date['data_id'])->get();
                }

                // Generate QR Code
                $qrcode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                    ->size(100)
                    ->errorCorrection('H')
                    ->generate('https://takip.marka.legal/tr/dashboard/report/' . $report->id));

                $html = "";

                $data = [];
                $counter = 0;
                foreach ($json['reports'] as $key => $keyword) {
                    $counter += count($keyword['keyword']['trademarks']);
                }
                $data['match_count'] = $counter;
                $data['user'] = $user;

                $reportValue = $report;
                $view = view('dashboard.pages.report.report-pdf')->with(compact('json', 'report', 'item', 'qrcode', 'data', 'userImages','reportValue'));
                $html .= $view->render();
                $html .= '<link type=text/css href="../public/dashboard/css/pdfstyle.css" rel="stylesheet">';
                $pdf = Pdf::loadHtml($html)->setPaper('a4', 'landscape');

                // Create PDF file.
                Storage::disk('pdf')->put("report_" . $pdfName, $pdf->output());

                // Sends to data needed to send the PDF to the queue.
                if ($subscription === 1) {
                    SendReportMail::dispatch($user, "report_" . $pdfName, $json['bulletins'], $report);
                }
            }
        }
        Log::channel('monitor')->info('Report queue finished. User: ' . $user->name);
    }
    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Log::channel('monitor')->error($exception);
    }
}
