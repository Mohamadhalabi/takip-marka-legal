<?php

namespace App\Http\Controllers;

use App\Classes\GenerateRegex\NormalSearch;
use App\Classes\GenerateRegex\ReverseSearch;
use App\Classes\GenerateRegex\SearchBySpace;
use App\Classes\TrademarkSearch;

class SearchController extends Controller
{
    public function index()
    {

        // Search Class
        $trademarkSearch = new TrademarkSearch();
        $exactMatchToken = '"';

        $keyword = 'inçin1';

        $exactMatchToken = '"';
        if (str_contains($keyword, $exactMatchToken)) {
            //Delete the $exactMatchToken character from $keyword and give the starting and ending index of the characters in between
            $exactMatchPosition = [];
            $exactMatchPosition['start'] = mb_strpos($keyword, $exactMatchToken);
            $exactMatchPosition['end'] = mb_strrpos($keyword, $exactMatchToken);

            $removedExactMatchToken = preg_replace('/"/', '', $keyword);

            for ($i = $exactMatchPosition['start']; $i <= $exactMatchPosition['end'] - 2; $i++) {
                $exactMatchIndexs[] = $i;
            }

            // Find all $exactMatchToken position and give the characters between them
            $exactMatchPosition = [];
            $exactMatchPosition['contains'] = true;
            $exactMatchPosition['start'] = mb_strpos($keyword, $exactMatchToken);
            $exactMatchPosition['end'] = mb_strrpos($keyword, $exactMatchToken);
            $exactMatchPosition['indexs'] = $exactMatchIndexs ?? [];

            if ($exactMatchPosition['start'] !== false && $exactMatchPosition['end'] !== false) {
                $exactMatchPosition['value'] = mb_substr($keyword, $exactMatchPosition['start'] + 1, $exactMatchPosition['end'] - $exactMatchPosition['start'] - 1);
            }
        } else {
            $exactMatchPosition['contains'] = false;
        }



        $data = [
            "exactMatch" => $exactMatchPosition,
            "original" => [
                "value" => $keyword,
                "length" => mb_strlen($keyword),
                "splitted" => mb_str_split(preg_replace('/"/', '', $keyword)),
            ],
        ];


        $normalSearch = new NormalSearch($data); // OKEY
        $reverseSearch = new ReverseSearch($data); // OKEY
        $searchBySpace = new SearchBySpace($data); // OKEY
        $data = [
            'regex' => $normalSearch->getRegex(),
            'reverseRegex' => $reverseSearch->getRegex(),
            'regexWithSpaces' => $searchBySpace->getRegex(),
        ];

        return $data;
    }
}
