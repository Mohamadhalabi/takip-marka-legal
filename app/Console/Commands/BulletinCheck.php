<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Command;

class BulletinCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bulletin:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        // API Call
        $apiURL = 'https://www.turkpatent.gov.tr/api/news?locale=tr&category=marka&limit=999';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $apiURL);
        $bulletins = json_decode($response->getBody(), true);

        // Error Handling
        if (!$bulletins['success']) {
            return "Error";
        }

        // Get all official trademark bulletins in API response
        $bulletins = $bulletins['payload']['data'];
        foreach ($bulletins as $bulletin) {
            foreach ($bulletin['media'] as $media) {
                if (str_contains($media['name'], 'Sayili_Marka_Bulten_CD_Icerigi.rar') || str_contains($media['name'], 'Sayili_Marka_Bulten_CD_Icerigi_rar.rar')) {
                    $rarFiles[] = $media;
                }
            }
        }

        $medias = Media::where('is_official', 1)->get();

        foreach ($rarFiles as $file) {
            $media = $medias->where('media_id', $file['id'])->first();
            if ($media) {
                $media->update([
                    'created_at' => $file['created_at'],
                    'bulletin_no' => substr($file['name'], 0, 3),
                ]);
                $media->save();
            }
        }

        // Get all official trademark bulletins in database
        $medias = Media::where('is_official', 1)->pluck('media_id')->toArray();
        foreach ($rarFiles as $file) {
            // If the official trademark bulletin is not in the database, save it
            if (!in_array($file['id'], $medias)) {
                $media = Media::create([
                    'media_id' => $file['id'],
                    'created_at' => $file['created_at'],
                    'slug' => 'https://webim.turkpatent.gov.tr/file/' . $file['slug'],
                    'type' => $file['type'],
                    'name' => $file['name'],
                    'title' => $file['title'],
                    'mime' =>  $file['mime'],
                    'size' => (int)$file['size'],
                    'extension' => $file['extension'],
                    'version' => $file['version'],
                    'path ' => $file['meta']['path'],
                    'data_id' => $file['data_id'] ?? null,
                    'is_official' => 1,
                    'is_saved' => 0,
                    'bulletin_no' => substr($file['name'], 0, 3),
                ]);
            }
        }
    }
}
