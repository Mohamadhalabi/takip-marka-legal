<?php

namespace App\Jobs;

use App\Classes\ImageCompare;
use App\Models\Trademark;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Classes\Bulletin as BulletinClass;
class FillTrademarkImageValue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $bulletin;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bulletin)
    {
        $this->bulletin = $bulletin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::channel('bulletin')->info('Start filling trademark image values');

        $trademarks = Trademark::where([
            'bulletin_id' => $this->bulletin->id,
            'histogram' => null,
            'phash' => null,
            'dominant_colors' => null,
        ])->get();

        if (count($trademarks) > 0) {
            Log::channel('bulletin')->info('Found ' . $trademarks->count() . ' trademark to fill image values.');
            $imageCompare = new ImageCompare();
            $count = 0;
            foreach ($trademarks as $trademark) {
                $path = storage_path('app/public/bulletin/' . replaceLastSlash($trademark->image_path));
                $dominantColors = $imageCompare->getDominantColors($path, 3);
                $histogram = $imageCompare->getHistogram($path);
                $phash = $imageCompare->getPHash($path);
                $trademark->dominant_colors = json_encode($dominantColors);
                $trademark->histogram = $histogram;
                $trademark->phash = $phash;
                $trademark->save();

                // her 100 kayıtta bir log tut
                $count++;
                if ($count % 100 == 0) {
                    Log::channel('bulletin')->info($count . ' trademark image values filled.');
                }
            }
            return $trademarks->count();
        }
        else{
            Log::channel('bulletin')->info('No trademark found to fill image values.');
        }

        Log::channel('bulletin')->info('Filled trademark image values.');
    }
}
