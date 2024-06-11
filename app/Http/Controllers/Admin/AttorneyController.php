<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attorney;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AttorneyController extends Controller
{
    public function index()
    {
        $apiURL = 'https://www.turkpatent.gov.tr/api/attorneys';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $apiURL);
        $attorneys = json_decode($response->getBody(), true);
        $brand_attorney = 0;
        $patent_attorney = 0;

        foreach ($attorneys as $attorney)
        {
            if($attorney['number'] == 'Marka Vekili')
            {
                $brand_attorney = 1;
                $patent_attorney = 0;
            }
            if($attorney['number'] == 'Patent Vekili')
            {
                $patent_attorney = 1;
                $brand_attorney = 0;
            }
            if($attorney['number'] == 'Patent ve Marka Vekili')
            {
                $brand_attorney = 1;
                $patent_attorney = 1;
            }
            $updated_at = Carbon::now()->format('Y-m-d H:i:s');
            Attorney::updateOrCreate([
                'number' => $attorney['number'],
                'name' => $attorney['name'],
                'company' => $attorney['company'],
                'city' => $attorney['city'],
                'address' => $attorney['address'],
                'phone' => $attorney['phone'],
                'email' => $attorney['email'],
                'brand_attorney' => $brand_attorney,
                'patent_attorney' => $patent_attorney,
            ]);
            if (Attorney::where('name',$attorney['name'])
                ->exists())
            {
                Attorney::where('name', $attorney['name'])
                    ->where('company',$attorney['company'])
                    ->update(['updated_at' => $updated_at]);
            }
        }
    }
}
