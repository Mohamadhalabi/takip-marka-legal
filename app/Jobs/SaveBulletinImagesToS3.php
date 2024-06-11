<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SaveBulletinImagesToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->path;
        $files = Storage::disk('images')->allFiles($path);
        foreach ($files as $file) {
            Storage::disk("s3")->writeStream('takip.marka.legal/images/'.$file, Storage::disk("images")->readStream($file));
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
    */
    public function failed($path)
    {
        $path = $this->path;
        Log::channel('monitor')->error('SaveBulletinImagesToS3 job failed. Path: ' . $path);
    }
}
