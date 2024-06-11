<?php

namespace App\Classes;

use App\Jobs\SaveBulletinImagesToS3;
use App\Models\Attorney;
use App\Models\ExtractedGood;
use App\Models\Good;
use App\Models\Holder;
use App\Models\Trademark;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class Bulletin
{
    public $media;
    public $log;

    public function __construct($media)
    {
        $this->media = $media;

        $this->log = Log::channel('bulletin');
    }

    /**
     * download the file from the url
     *
     * @return void
     */
    public function download()
    {
        $url = $this->media->slug;
        if($this->media->total != 0){
            Log::channel('bulletin')->info('bulletin already downloaded');
            return;
        }
        try {
            $this->log->info('download started');
            $guzzle = new Client();
            $response = $guzzle->get($url . '?download');
            $this->log->info($url.'?download');
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Download failed. HTTP status code: ' . $response->getStatusCode());
            }

            $this->log->info('download finished');

            $filePath = Storage::path('/tmp/' . $this->media->media_id . '.rar');
            Storage::put('/tmp/' . $this->media->media_id . '.rar', $response->getBody());

            // File existence check
            if (!file_exists($filePath)) {
                throw new \Exception('Downloaded file does not exist.');
            }

            if (pathinfo($filePath)['extension'] != 'rar') {
                $this->log->info('file is not rar');
            }

            // File size check
            if (filesize($filePath) < 1000000) {
                throw new \Exception('Downloaded file size is less than 1mb.');
            }

            $this->log->info('file saved to storage tmp folder');
        } catch (\Exception $e) {
            $this->log->error('Error during download: ' . $e->getMessage());
        }
    }

    /**
     * extract rar file
     *
     * @return void
     */
    public function extract()
    {
        ini_set('memory_limit', '512M');
        $path = Storage::path('/tmp/' . $this->media->media_id . '.rar');
        $destination = Storage::path('/tmp/');

        // Unrar the file
        $unrarPath = env('UNRAR_PATH');
        $command = $unrarPath." x -o+ " . escapeshellarg($path) . " " . escapeshellarg($destination) . " 2>&1";
        $this->log->info($command);

        $output = [];
        $return_var = 0;
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            $this->log->info('Error executing the unrar command');
            $this->log->info(print_r($output, true));
            return;
        }

        // Log the output
        $this->log->info('Unrar command executed, return_var: ' . $return_var);
        if (in_array('All OK', $output)) {
            $this->log->info('Extracted successfully');

            $imageFolder = Storage::path('/tmp/' . $this->media->bulletin_no . '/data/images');
            $imageDestination = Storage::path('/public/bulletin/' . $this->media->bulletin_no . '/images');

            // move imageFolder images to imageDestination folder
            File::copyDirectory($imageFolder, $imageDestination);
            Log::channel('bulletin')->info('images moved to public folder');
        }

    }

    /**
     * parse
     *
     * @return void
     */
    public function parse()
    {
        ini_set('memory_limit', '512M');
        if($this->media->total != 0){
            Log::channel('bulletin')->info('bulletin already parsed');
            return;
        }

        $lines_array = Storage::disk('tmp')->get(substr($this->media->name, 0, 3) . '/data/tmbulletin.log');
        $lines_array = explode("\n", $lines_array);
        // save each line in tmbulletinbulletin.log file into array
        foreach ($lines_array as $line => $index) {
            $lines[$index] = $line;
        }

        // deletes the first 14 unnecessary lines from the file (these lines are consistent with all bulletins)
        $lines = array_slice($lines, 14);
        $lines_formatted = [];
        foreach ($lines as $line => $index) {
            // Parses trademark data from within the file and saves it to the array
            if (str_contains($line, 'INSERT INTO TRADEMARK VALUES')) {
                $pattern = "/INSERT INTO TRADEMARK VALUES\('(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)'\)/";
                preg_match_all($pattern, $line, $matches);
                $lines_formatted['application_no'][$matches[1][0]]['trademark'] = array(
                    'application_date' => $matches[2][0],
                    'register_no' => $matches[3][0],
                    'register_date' => $matches[4][0],
                    'intreg_no' => $matches[5][0],
                    'name' => unescapeToString($matches[6][0]),
                    'nice_classes' => $matches[7][0],
                    'vienna_classes' => $matches[8][0],
                    'type' => $matches[9][0],
                    'pub_type' => $matches[10][0]
                );
            }
            // Parses holder data from within the file and saves it to the array
            else if (str_contains($line, 'INSERT INTO HOLDER VALUES')) {
                $pattern = "/INSERT INTO HOLDER VALUES\('(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)','(.*?)'\)/";
                preg_match_all($pattern, $line, $matches);
                $lines_formatted['application_no'][$matches[1][0]]['holder'] = array(
                    'tpec_client_id' => $matches[2][0],
                    'title' => unescapeToString($matches[3][0]),
                    'address' => unescapeToString($matches[4][0]),
                    'state' => unescapeToString($matches[5][0]),
                    'postal_code' => $matches[6][0],
                    'city' => unescapeToString($matches[7][0]),
                    'country_no' => unescapeToString($matches[8][0])
                );
            }
            // Parses extracted good data from within the file and saves it to the array
            else if (str_contains($line, 'INSERT INTO GOODS VALUE')) {
                $pattern = "/INSERT INTO GOODS VALUES\('(.*?)','(.*?)','(.*?)','(.*?)'\)/";
                preg_match_all($pattern, $line, $matches);
                $lines_formatted['application_no'][$matches[1][0]]['good'] = array(
                    'class_id' => $matches[2][0],
                    'subclass_id' => $matches[3][0],
                    'goods' => unescapeToString($matches[4][0])
                );
            }
            // Parses extracted good data from within the file and saves it to the array
            else if (str_contains($line, 'INSERT INTO EXTRACTEDGOODS VALUES')) {
                $pattern = "/INSERT INTO EXTRACTEDGOODS VALUES\('(.*?)','(.*?)','(.*?)','(.*?)'\)/";
                preg_match_all($pattern, $line, $matches);
                $lines_formatted['application_no'][$matches[1][0]]['extracted_good'] = array(
                    'class_id' => $matches[2][0],
                    'subclass_id' => $matches[3][0],
                    'goods' => unescapeToString($matches[4][0])
                );
            }
            // Parses extracted attorney data from within the file and saves it to the array
            else if (str_contains($line, 'INSERT INTO ATTORNEY VALUES')) {
                $pattern = "/INSERT INTO ATTORNEY VALUES\('(.*?)','(.*?)','(.*?)','(.*?)'\)/";
                preg_match_all($pattern, $line, $matches);
                $lines_formatted['application_no'][$matches[1][0]]['attorney'] = array(
                    'application_no' => $matches[1][0],
                    'no' => $matches[2][0],
                    'name' => unescapeToString($matches[3][0]),
                    'title' => unescapeToString($matches[4][0])
                );
            } else {
                $lines_formatted[$index] = $line;
            }
        }

        $now = Carbon::now();

        // The data transferred to the array was formatted and made readable.
        foreach ($lines_formatted['application_no'] as $application_no => $application) {
            $data['trademark'][] = [
                'application_no' => $application_no,
                'application_date' => $application['trademark']['application_date'] ?? '',
                'register_no' => $application['trademark']['register_no'] ?? '',
                'register_date' => $application['trademark']['register_date'] ?? '',
                'intreg_no' => $application['trademark']['intreg_no'] ?? '',
                'name' => $application['trademark']['name'] ?? '',
                'slug' => str_replace('-', '', Str::slug($application['trademark']['name'])) ?? '',
                'nice_classes' => $application['trademark']['nice_classes'] ?? '',
                'vienna_classes' => $application['trademark']['vienna_classes'] ?? '',
                'type' => $application['trademark']['type'] ?? '',
                'pub_type' => $application['trademark']['pub_type'] ?? '',
                'image_path' => substr($this->media->name, 0, 3) . '/images/' . $application_no . '.jpg',
                'bulletin_id' => $this->media->id,
                'attorney_no' => $application['attorney']['no'] ?? '',
                'attorney_name' => $application['attorney']['name'] ?? '',
                'attorney_title' => $application['attorney']['title'] ?? '',
                'holder_tpec_client_id' => $application['holder']['tpec_client_id'] ?? '',
                'holder_title' => $application['holder']['title'] ?? '',
                'holder_address' => $application['holder']['address'] ?? '',
                'holder_state' => $application['holder']['state'] ?? '',
                'holder_postal_code' => $application['holder']['postal_code'] ?? '',
                'holder_city' => $application['holder']['city'] ?? '',
                'holder_country_no' => $application['holder']['country_no'] ?? '',
                'good_class_id' => $application['good']['class_id'] ?? '',
                'good_subclass_id' => $application['good']['subclass_id'] ?? '',
                'good_description' => $application['good']['goods'] ?? '',
                'extracted_good_class_id' => $application['extracted_good']['class_id'] ?? '',
                'extracted_good_subclass_id' => $application['extracted_good']['subclass_id'] ?? '',
                'extracted_good_description' => $application['extracted_good']['goods'] ?? '',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        //Trademark data is saved to the trademark table.
        foreach (array_chunk($data['trademark'], 500) as $chunk) {
            Trademark::insert($chunk);
        }
        Log::channel('bulletin')->info('trademark table saved');

        // Update the bulletin from the server.
        $this->media->is_saved = 1;
        $this->media->total = count($data['trademark']);
        $this->media->save();
        Log::channel('bulletin')->info('media updated');
        Log::channel('bulletin')->info('total: ' . $this->media->total);

        // delete tmp folder Storage::disk('tmp') içerisindeki tüm dosyaları siler.
        // Storage::disk('tmp')->deleteDirectory('/');
        Log::channel('bulletin')->info('tmp folder deleted');
    }
}
