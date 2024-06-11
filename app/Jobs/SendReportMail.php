<?php

namespace App\Jobs;

use App\Models\Error;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;
use Mail;
use Throwable;

class SendReportMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pdf;
    public $user;
    public $report;
    public $json;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $pdfFile, $json,$report)
    {
        $this->user = $user;
        $this->pdf = $pdfFile;
        $this->json = $json;
        $this->report = $report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Data to be process.
        $report = $this->report;
        $json = $this->json;
        $user = $this->user;
        $pdfFile = $this->pdf;
        $date = Carbon::now();

        // Email settings.
        $data["email"] = "info@marka.legal";
        $data["title"] = "Yeni Rapor | takip.marka.legal";

        // Check PDF file.
        if(Storage::disk('pdf')->exists($pdfFile))
        {
            // Send email.
            Mail::send('emails.report-email',compact('json','user','date','report'), function($message) use ($user, $pdfFile) {
                $message->to($user->email)
                    ->subject("Yeni Rapor | " . env('APP_NAME'));
                $message->attach(storage_path('app/pdf/'.$pdfFile));
            });
        }
        else
        {
            $error = new Error();
            $error->user_id = $user->id;
            $error->message = "PDF dosyası bulunamadı.";
            $error->save();
        }

    }
    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Error::create([
            'user_id' => 1,
            'message' => $exception->getMessage(),
        ]);
        Log::channel('monitor')->error($exception);
    }
}
