<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageSearch extends Controller
{
    /**
     * search
     *
     * @param  mixed  $request
     * @return void
     */
    public function search(Request $request)
    {
        $data = [];
        $start_time = microtime(true);

        // storage/app/public/images içerisinden ilk 100 görselin yolunu kopyala
        $files = Storage::files('public/images');
        $files = array_filter($files, function ($file) {
            return strpos($file, 'jpg') !== false;
        });
        $files = array_slice($files, 3500, 1);

        // storage/app/public/images içerisinden 2022_153658.jpg dosyasının yolunu bul
        $image_name = '2023_047875';
        $image = 'public/images/'.$image_name.'.jpg';
        $main_image = Storage::path($image);

        foreach ($files as $key => $file) {
            $ch = curl_init('http://localhost:8284/surf/keypoints-and-descriptors');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['image_path' => $main_image, 'image2_path' => Storage::path($file)]));
            // return $images;
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            // return $response;
            $data[$key] = [
                // public to storage
                'image' => preg_replace('/public/', 'storage', $image),
                'image_s' => preg_replace('/public/', 'storage', $file),
                'similarities' => $response,

            ];
            curl_close($ch);
            return $data;
        }
        // sonuçları $data içerisindeki similarities anahtarının içerisindeki histogram değerlerine göre sırala
        usort($data, function ($a, $b) {
            // eğer $a ve ya $b tanımlıysa
            if (isset($a['similarities']) && isset($b['similarities'])) {
                // $a ve $b'nin similarities anahtarının içerisindeki histogram değerlerini karşılaştır
                return $b['similarities']['histogram'] <=> $a['similarities']['histogram'];
            }
        });

        // şimdi de $data içerisindeki similarities anahtarının içerisindeki phash değerlerine göre sırala
        usort($data, function ($a, $b) {
            // eğer $a ve ya $b tanımlıysa
            if (isset($a['similarities']) && isset($b['similarities'])) {
                // $a ve $b'nin similarities anahtarının içerisindeki phash değerlerini karşılaştır
                return $b['similarities']['phash'] <=> $a['similarities']['phash'];
            }
        });

        $end_time = microtime(true);
        $time = $end_time - $start_time;

        return view('dashboard.pages.search-by-image', compact('data', 'time'));
    }
}