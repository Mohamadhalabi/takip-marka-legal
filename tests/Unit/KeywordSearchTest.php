<?php

namespace Tests\Unit;

use App\Classes\TrademarkSearch;
use Tests\TestCase;

class KeywordSearchTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_keyword_search()
    {
        // Create new TrademarkSearch object
        $search = new TrademarkSearch();

        // Import csv file
        $file = public_path('csv/test-file.csv');
        $csv = array_map('str_getcsv', file($file));
        $csv = array_slice($csv, 1);

        // Filter empty lines
        $csv = array_map(function ($item) {
            if ($item[0] != '' || $item[1] != '' || $item[2] != '')
                return [
                    'test_no' => $item[0] ?? '',
                    'keyword' => $item[1] ?? '',
                    'string' => $item[2] ?? '',
                    'bulletin_no' => $item[3] ?? '',
                    'trademark_id' => $item[4] ?? '',
                    'type' => $item[5] ?? '',
                    'must' => $item[6] ?? '',
                    'match' => $item[7] ?? '',
                ];
        }, $csv);

        // Create empty results array
        $results = [];

        foreach ($csv as $line) {
            // $keyword = $line['keyword'];
            $string = $line['string'];

            // Convert keyword to lowercase
            $keyword['string'] = $search->str2lower($line['keyword']);
            // Break down keyword word by word
            $keyword['fragments'] = $search->getExplodedData($keyword['string'], ' ');


            // Get word count
            $wordCount = count($keyword['fragments']);
            // Check that the trademark contains the sought nice classes and that the sought nice classes are not empty.
            // Start counter
            $counter = 0;

            // Matched fragments
            $matchedFragments = [];
            // return
            // Loop all words belonging to keyword
            foreach ($keyword['fragments'] as $key => $fragment) {
                // Create the regex according to the desired word and rules
                $regex = $search->searchRules($fragment);
                // Query regex in $trademark->name
                // Punctuation marks and the characters to convert.
                $replace = [
                    ' ' => ' ',
                    // '-' => '',
                    // '.' => '',
                    // ',' => '',
                    // '/' => '',
                    // '\\' => '',
                    // '[' => '',
                    // ']' => '',
                    // '{' => '',
                    // '}' => '',
                    // '!' => '',
                    // '?' => '',
                    // '*' => '',
                    // '+' => '',
                    // "'" => '',
                    // '"' => '',
                    // '’' => '',
                    // '‘' => '',
                    // '“' => '',
                    // '”' => '',
                    // '–' => '',
                    // '—' => '',
                    // '…' => '',
                    // 'ı' => 'i',
                    // 'İ' => 'i',
                    // 'ö' => 'o',
                    // 'Ö' => 'o',
                    // 'ü' => 'u',
                    // 'Ü' => 'u',
                    // 'ş' => 's',
                    // 'Ş' => 's',
                    // 'ğ' => 'g',
                    // 'Ğ' => 'g',
                    // 'ç' => 'c',
                    // 'Ç' => 'c',
                ];
                $string = strtr($line['keyword'], $replace);

                if (preg_match("/$regex/i", $string, $matches)) {
                    // Save matching word in array
                    $matchedFragments[$key] = $fragment;
                    // If there is a match, increase the counter
                    $counter++;
                }
            }
            $status = false;
            if($line['match'] == 1 && $matchedFragments == true){
                $status = true;
            }
            else if($line['match'] == 0 && $matchedFragments == false){
                $status = true;
            }
            else{
                $status = false;
            }
            // Add a new field to the filtered trademark and save the matching words.
            $response = [
                'matched' => $status,
                'test_no' => $line['test_no'],
                'keyword' => $keyword['string'],
                'string' => $string,
                'bulletin' => $line['bulletin_no'],
                'trademark' => $line['trademark_id'],
                'matches' => $matchedFragments,
                'type' => $line['type'],
                'is_match' => $line['match'],
                'is_must' => $line['must'],
            ];

            // Respond based on the keyword's word count condition.
            $results['testLines'][] = $response;
        }

        // Summary
        $results['summary'] = [
            'created_at' => now()->format('H:i:s d.m.Y'),
            'total' => count($csv),
            'matched' => count(array_filter($results['testLines'], function ($item) {
                return $item['matched'] == true;
            })),
            'unmatched' => count(array_filter($results['testLines'], function ($item) {
                return $item['matched'] == false;
            })),
        ];

        // return view('test-output', compact('results'));
        $view = view('test-output', compact('results'))->render();

        // Save html file
        file_put_contents(public_path() . '/tests/report-' . now()->format('H-i-s-d-m-Y') . '.html', $view);

        // Check if all tests are passed
        if($results['summary']['matched'] == $results['summary']['total'])
            $this->assertTrue(true);
    }
}
