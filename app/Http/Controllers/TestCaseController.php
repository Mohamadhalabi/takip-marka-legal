<?php

namespace App\Http\Controllers;

use App\Classes\TrademarkSearch;
use Illuminate\Support\Facades\Storage;

class TestCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $csvFile = Storage::drive('csv')->get('test-cases.csv');
        $rows = array_map('str_getcsv', explode("\n", $csvFile));
        $header = array_shift($rows);
        $csv = array();

        $search = new TrademarkSearch();
        $success = 0;
        foreach ($rows as $row) {
            $case = array_combine($header, $row);
            $searchedClasses = [];
            $excluesionKeywords = [];
            $keyword = [
                'string' => $search->str2lower($case['keyword']),
                'fragments' => $search->getExplodedData($search->str2lower($case['keyword']), ' ')
            ];
            $trademark = [
                'nice_classes' => null,
                'name' => $case['string']
            ];
            try {
                if($keyword['string'] == 'sattım'){
                    $searchResult = $search->searchWithRegex($keyword, $trademark, $searchedClasses, $search, $excluesionKeywords);
                    return $searchResult;
                    // return htmlspecialchars($searchResult);
                    // return "herexx";
                }
                $searchResult = $search->searchWithRegex($keyword, $trademark, $searchedClasses, $search, $excluesionKeywords);
            } catch (\Throwable $th) {
                $searchResult = 1;
            }
            $match = ($searchResult == null) ? 0 : 1;
            $case['result'] = ($case['match'] == $match) ? 1 : 0;
            $case['score'] = $searchResult['_filtered']['score'] ?? 0;
            $case['reverse_score'] = $searchResult['_filtered']['reverse_score'] ?? 0;
            if ($case['result'] == 1) {
                $success++;
            }
            $csv[] = $case;
        }

        return view('dashboard.admin.tests.index', compact('csv', 'success'));
    }
}
