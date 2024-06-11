<?php

namespace App\Http\Controllers\Search;

use App\Classes\GenerateRegex\NormalSearch;
use App\Classes\GenerateRegex\ReverseSearch;
use App\Classes\GenerateRegex\SearchBySpace;
use App\Classes\TrademarkSearch;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StandartSearch extends Controller
{
    public function index()
    {
        $bulletins = Media::where('is_official', 1)->where('is_saved', 1)->latest()->take(5)->get();
        return view('dashboard.pages.search')->with('bulletins', $bulletins);
    }
    /**
     * Standart Search Index Page
     *
     * @return void
     */
    public function search(Request $request)
    {
        // get keyword and exclusion keywords from request
        $input = $request->keyword;
        $exclusionKeywords = json_decode($request->exclusion_keywords, true);

        // searched classes
        $searchedClasses = $request->input('classes') ?? [];

        if ($exclusionKeywords != null) {
            // convert exclusion keywords to array
            $exclusionKeywords = array_column($exclusionKeywords, 'value');
            if (count($exclusionKeywords) > 10) {
                // accept only 10 exclusion keywords
                $exclusionKeywords = array_slice($exclusionKeywords, 0, 10);
            }
        }

        // exact match character validation
        $exactMatchCharacterCount = substr_count($input, '"');
        if ($exactMatchCharacterCount > 0 && $exactMatchCharacterCount != 2) {
            return redirect()->back()->withErrors(['keyword' => 'Lütfen arama yaparken tırnak işareti(") kullanımını doğru bir şekilde yapınız.']);
        }
        $ts = new TrademarkSearch();

        $keyword = $ts->str2lower($input);

        // k e y w o r d => keyword (remove spaces)
        $keyword = trim(preg_replace('/\s+/', ' ', $keyword));
        $spaces = substr_count($keyword, ' ');
        if ($spaces * 2 == mb_strlen($keyword) - 1) {
            $keyword = str_replace(' ', '', $keyword);
        }

        $data = [
            'string' => $ts->str2lower($keyword),
            'fragments' => $ts->getExplodedData($keyword, ' '),
            'exclusion_keywords' => $exclusionKeywords,
            'searched_classes' => $searchedClasses,
        ];


        // timer start
        $startTime = microtime(true);

        // trademarks to search
        $trademarks = [];

        $bulletin = $request->bulletins;
        $trademarks = DB::select('select id,name,nice_classes from trademarks where bulletin_id = ?', [$bulletin]);

        $filteredTrademarks = [];
        $exactMatchToken = '"';
        $exactMatchPosition['contains'] = false;

        // find exact match position
        $data['exactMatch'] = $exactMatchPosition;
        $data['original']['value'] = $keyword;
        $data['original']['length'] = mb_strlen($keyword);
        $data['original']['splitted'] = mb_str_split(preg_replace('/"/', '', $keyword));
        // remove spaces in $data['original']['splitted']
        $data['original']['splitted'] = array_filter($data['original']['splitted'], function ($value) {
            return $value !== ' ';
        });

        $fragments = [];
        // search fragment
        foreach ($data['fragments'] as $fragment) {
            if (str_contains($fragment, $exactMatchToken)) {
                // delete the $exactMatchToken character from $keyword and give the starting and ending index of the characters in between
                $exactMatchPosition = [];
                $exactMatchPosition['start'] = mb_strpos($fragment, $exactMatchToken);
                $exactMatchPosition['end'] = mb_strrpos($fragment, $exactMatchToken);

                $removedExactMatchToken = preg_replace('/"/', '', $fragment);

                for ($i = $exactMatchPosition['start']; $i <= $exactMatchPosition['end'] - 2; $i++) {
                    $exactMatchIndexs[] = $i;
                }

                // find all $exactMatchToken position and give the characters between them
                $exactMatchPosition = [];
                $exactMatchPosition['contains'] = true;
                $exactMatchPosition['start'] = mb_strpos($fragment, $exactMatchToken);
                $exactMatchPosition['end'] = mb_strrpos($fragment, $exactMatchToken);
                $exactMatchPosition['indexs'] = $exactMatchIndexs ?? [];
                if ($exactMatchPosition['start'] !== false && $exactMatchPosition['end'] !== false) {
                    $exactMatchPosition['value'] = mb_substr($fragment, $exactMatchPosition['start'] + 1, $exactMatchPosition['end'] - $exactMatchPosition['start'] - 1);
                }
            } else {
                $exactMatchPosition['contains'] = false;
            }

            $classData = [
                'original' => [
                    'splitted' => mb_str_split(preg_replace('/"/', '', $fragment))
                ],
                'exactMatch' => [
                    'contains' => $exactMatchPosition['contains'],
                    'indexs' => $exactMatchPosition['indexs'] ?? [],
                ]
            ];

            $flatSearch = new NormalSearch($classData);
            $reverseSearch = new ReverseSearch($classData);
            $searchBySpace = new SearchBySpace($classData);

            $regularExpressions['flat'] = $flatSearch->getRegex();
            $regularExpressions['reverse'] = $reverseSearch->getRegex();
            $regularExpressions['space'] = $searchBySpace->getRegex();

            $fragments[] = [
                'value' => $fragment,
                'length' => mb_strlen($fragment),
                'splitted' => mb_str_split($fragment),
                'exactMatch' => $exactMatchPosition,
                'regularExpressions' => $regularExpressions,
            ];
        }
        // return $fragments;
        // search
        foreach ($trademarks as $trademark) {
            $wordCount = count($data['fragments']);

            $trademarkClasses = $ts->getExplodedData($trademark->nice_classes ?? '');
            // convert 05 to 5
            $trademarkClasses = array_map(function ($value) {
                return (int) $value;
            }, $trademarkClasses);

            $searchedClasses = array_map(function ($value) {
                return (int) $value;
            }, $searchedClasses);

            $isMatchedClasses = $ts->isMatchedClasses($trademarkClasses, $searchedClasses);

            // if searched classes is not empty and trademark classes is not matched with searched classes
            if ($searchedClasses && $isMatchedClasses != 1) {
                continue;
            }

            $counter = 0;
            $reverseCounter = 0;
            $regexWithSpacesCounter = 0;

            $matchedFragments = [];
            $highlights = [];

            $normalScore = 0;
            $reverseScore = 0;

            $string = $trademark->name;
            foreach ($fragments as $fragment) {

                $flat = $fragment['regularExpressions']['flat'];
                $reverse = $fragment['regularExpressions']['reverse']['regex'];
                $regexWithSpaces = $fragment['regularExpressions']['space'];
                /*
                * Normal Search
                */
                if (preg_match("/\b\w*$flat\w*\b/iu", $string, $matches)) {
                    $hl = preg_match("/$flat/iu", $string, $normalHl);
                    $highlights[] = $normalHl[0];
                    $matchCounter = 0;
                    $chars = [];

                    foreach ($matches as $key => $value) {
                        if (strpos($key, "match") === 0 && $value != '') {
                            $matchCounter++;
                        }
                        if (strpos($key, "c") === 0 && $value != '') {
                            $chars[] = $value;
                        }
                    }
                    // remove null values and spaces in $chars
                    $chars = array_filter($chars, function ($char) {
                        return $char != null && $char != ' ';
                    });
                    $fragment_splitted = $fragment['splitted'];
                    $transforms = [];

                    $totalConversionScore = 0;
                    $i = 0;
                    foreach ($chars as $char) {
                        $transforms[] = [
                            'from' => $fragment_splitted[$i],
                            'to' => $char,
                            'transform' => ($fragment_splitted[$i] == $char) ? 'same' : 'different',
                        ];

                        $totalConversionScore += $ts->getConversionScore($fragment_splitted[$i], $char);
                        $i++;
                    }


                    $totalConversionScore += $matchCounter * 1;
                    $normalScore = $totalConversionScore;
                    $differentChars = array_filter($transforms, function ($transform) {
                        return $transform['transform'] == 'different';
                    });

                    $matchedString = $matches[0] ?? '';
                    $charCount = mb_strlen($fragment['value']);

                    // Check if last character exists
                    $lastCharacter = $matches['lastChar'] ?? '';
                    $hasLastChar = ($lastCharacter != '') ? true : false;

                    $exclusionMatch = false;
                    try {
                        foreach ($exclusionKeywords as $exclusionKeyword) {
                            if (str_contains($matchedString, $exclusionKeyword)) {
                                $exclusionMatch = true;
                                break;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::channel('monitor')->info($e->getMessage());
                    }

                    if ($exclusionMatch) {
                        break;
                    }

                    if ($exactMatchPosition['contains'] == true && str_contains($matchedString, $exactMatchPosition['value']) == false) {
                        break;
                    }

                    /**
                     * Calculating suffix penalty points for two characters in search
                     */
                    if ($charCount == 2) {
                        $tmp_str = $matches[0];
                        $tmp_str = str_replace($normalHl[0], '', $tmp_str);
                        $str_count = mb_strlen($tmp_str);
                        $rTotalConversionScore = $totalConversionScore + ($str_count * 1);
                    }

                    /**
                     * * Normal Search
                     */
                    // Fragment length : 1
                    // if ($charCount == 1) {
                    if ($charCount == 1 && $totalConversionScore <= 1.50) {
                        $matchedFragments[$key] = $fragment;
                        $counter++;
                    }
                    // Fragment length : 2
                    // else if ($charCount == 2) {
                    else if ($charCount == 2 && $totalConversionScore <= 1.50) {
                        if (mb_strlen($matches[0]) <= 4) {
                            $matchedFragments[$key] = $fragment;
                            $counter++;
                        }
                    }
                    // Fragment length : 3
                    // else if ($charCount == 3) {
                    else if ($charCount == 3 && $totalConversionScore <= 1.25) {
                        if ($matchCounter <= 1) {
                            $matchedFragments[$key] = $fragment;
                            $counter++;
                        }
                        // Fragment length : 4
                        // } else if ($charCount == 4) {
                    } else if ($charCount == 4 && $totalConversionScore <= 1.50) {
                        // If the last character exists, the match counter must be less than or equal to 1.
                        if ($matchCounter <= 1) {
                            $matchedFragments[$key] = $fragment;
                            $counter++;
                        }
                        // Fragment length : 5
                        // } else if ($charCount == 5) {
                    } else if ($charCount == 5 && $totalConversionScore <= 1.50) {
                        // If the last character exists, the match counter must be less than or equal to 1.
                        if ($hasLastChar && $matchCounter <= 1) {
                            $matchedFragments[$key] = $fragment;
                            $counter++;
                            // If the last character does not exist, the match counter must be equal to 0.
                        } else if (!$hasLastChar && $matchCounter == 0) {
                            $matchedFragments[$key] = $fragment;
                            $counter++;
                        }
                        // $matchedFragments[$key] = $fragment;
                        //     $counter++;
                        // } else if ($charCount >= 6) {
                    } else if ($charCount >= 6 && $totalConversionScore <= 1.50) {
                        // If the last character exists, the match counter must be less than or equal to 1.
                        if ($hasLastChar && $matchCounter <= 1) {
                            $matchedFragments[$key] = $fragment;
                            $counter++;
                            // If the last character does not exist, the match counter must be equal to 0.
                        } else if (!$hasLastChar && $matchCounter == 0) {
                            $matchedFragments[$key] = $fragment;
                            $counter++;
                        }
                        // $matchedFragments[$key] = $fragment;
                        //     $counter++;
                    }
                }

                /**
                 * * Reverse Search
                 */
                if (preg_match("/\b\w*$reverse\w*\b/iu", $string, $reverseMatches)) {
                    // Log::channel('monitor')->info("\b\w*$reverse\w*\b");
                    $rhl = preg_match("/$reverse/iu", $string, $reverseHighlight);
                    $highlights[] = $reverseHighlight[0];
                    $reverseMatchCounter = 0;
                    $c = 0;
                    $rChars = [];
                    $rTotalConversionScore = 0;
                    foreach ($reverseMatches as $key => $value) {
                        if (strpos($key, "rMatch") === 0 && $value != '') {
                            $reverseMatchCounter++;
                            $c++;
                        }
                        if (strpos($key, "c") === 0 && $value != '') {
                            $rChars[] = $value;
                        }
                    }

                    $r_fragment_splitted = $fragment['splitted'];
                    $rTransforms = [];
                    foreach ($rChars as $rIndex => $rChar) {
                        $rTransforms[] = [
                            'from' => $r_fragment_splitted[$rIndex],
                            'to' => $rChar,
                            'transform' => ($r_fragment_splitted[$rIndex] == $rChar) ? 'same' : 'different',
                        ];
                        $rTotalConversionScore += $ts->getConversionScore($r_fragment_splitted[$rIndex], $rChar) * 1;
                    }
                    // Log::channel('monitor')->info($rTransforms);
                    $rTotalConversionScore += $c * 1;
                    $reverseScore = $rTotalConversionScore;
                    $rDifferentChars = array_filter($rTransforms, function ($rTransform) {
                        return $rTransform['transform'] == 'different';
                    });

                    $reverseCharCount = $fragment['regularExpressions']['reverse']['length'];
                    $reverseLastCharacter = $reverseMatches['rLastChar'] ?? '';
                    $reverseHasLastChar = ($reverseLastCharacter != '') ? true : false;
                    $matchedReverseString = $reverseMatches[0] ?? '';

                    $exclusionReverseMatch = false;
                    try {
                        foreach ($exclusionKeywords as $exclusionKeyword) {
                            if (str_contains($matchedReverseString, $exclusionKeyword)) {
                                $exclusionReverseMatch = true;
                                break;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::channel('monitor')->info($e->getMessage());
                    }

                    if ($exclusionReverseMatch) {
                        break;
                    }


                    if ($exactMatchPosition['contains'] == true && str_contains($matchedReverseString, $exactMatchPosition['value']) == false) {
                        break;
                    }

                    /**
                     * Calculating suffix penalty points for two characters in reverse search
                     */
                    if ($reverseCharCount == 2) {
                        $tmp_str = $reverseMatches[0];
                        $tmp_str = str_replace($reverseHighlight[0], '', $tmp_str);
                        $str_count = mb_strlen($tmp_str);
                        $rTotalConversionScore = $rTotalConversionScore + ($str_count * 0.25);
                    }

                    /**
                     * * Reverse Search
                     * ? If there is a match in the normal search, the reverse search check is not performed.
                     */
                    // Reverse regex character length : 1

                    // if ($reverseCharCount == 1) {
                    if ($reverseCharCount == 1 && $rTotalConversionScore <= 1.50) {
                        $matchedFragments[$key] = $fragment;
                        $reverseCounter++;
                        // Log::channel('monitor')->info("Reverse regex character :" . $fragment);
                    }
                    // Reverse regex character length : 2
                    // else if ($reverseCharCount == 2) {
                    else if ($reverseCharCount == 2 && $rTotalConversionScore <= 1.50) {
                        if (mb_strlen($reverseMatches[0]) <= 4) {
                            $matchedFragments[$key] = $fragment;
                            if ($reverseMatchCounter == 0) {
                                $reverseCounter++;
                            }
                        }
                    }
                    // Reverse regex character length : 3
                    // else if ($reverseCharCount == 3) {
                    else if ($reverseCharCount == 3 && $rTotalConversionScore <= 1.25) {
                        if ($reverseMatchCounter == 0) {
                            $matchedFragments[$key] = $fragment;
                            $reverseCounter++;
                        }
                    }
                    // Reverse regex character length : 4
                    // else if ($reverseCharCount == 4) {
                    else if ($reverseCharCount == 4 && $rTotalConversionScore <= 1.50) {
                        if ($reverseMatchCounter <= 1) {
                            $matchedFragments[$key] = $fragment;
                            $reverseCounter++;
                        }
                    }
                    // Reverse regex character length : 5
                    // else if ($reverseCharCount == 5) {
                    else if ($reverseCharCount == 5 && $rTotalConversionScore <= 1.50) {
                        if ($reverseHasLastChar && $reverseMatchCounter <= 1) {
                            $matchedFragments[$key] = $fragment;
                            $reverseCounter++;
                        } else if (!$reverseHasLastChar && $reverseMatchCounter == 0) {
                            $matchedFragments[$key] = $fragment;
                            $reverseCounter++;
                        }
                    }
                    // Reverse regex character length : >= 6
                    // else if ($reverseCharCount >= 6) {
                    else if ($reverseCharCount >= 6 && $rTotalConversionScore <= 1.50) {
                        if ($reverseHasLastChar && $reverseMatchCounter <= 1) {
                            $matchedFragments[$key] = $fragment;
                            $reverseCounter++;
                        } else if (!$reverseHasLastChar && $reverseMatchCounter == 0) {
                            $matchedFragments[$key] = $fragment;
                            $reverseCounter++;
                        }
                    }
                }

                /**
                 * * Search by spaces
                 */
                try {
                    if (preg_match("/(?<=\s|^)$regexWithSpaces(?=\s|$)/iu", $string, $spacesMatches)) {
                        $regexWithSpacesCounter = true;
                        $matchedFragments[$key] = $fragment;
                        $highlights[] = $spacesMatches[0];
                    } else $regexWithSpacesCounter = false;
                } catch (\Exception $e) {
                    $regexWithSpacesCounter = false;
                    Log::channel('monitor')->info($regexWithSpaces);
                    Log::channel('monitor')->info($string);
                }

                if ($matchedFragments) {
                    // Add a new field to the filtered trademark and save the matching words.
                    $trademark->_filtered = [
                        // 'name' => $trademark['name'],
                        // 'classes' => $trademark->nice_classes,
                        'matches' => $matchedFragments,
                        'highlights' => array_unique($highlights),
                        'score' => $normalScore,
                        'reverse_score' => $reverseScore,
                        // 'matched_classes' => array_intersect($search->getExplodedData($trademark->nice_classes), $searchedClasses)
                    ];
                }

                // Respond based on the keyword's word count condition.
                if ($ts->matchingWordCountRules($wordCount, $reverseCounter) || $ts->matchingWordCountRules($wordCount, $counter) || $regexWithSpacesCounter) {
                    $trademark->status = 'matched';
                    $filteredTrademarks[] = $trademark;
                }
            }
        }

        // timer end
        $endTime = microtime(true);

        // if $trademarks count > 1000, get first 1000 value
        if (count($filteredTrademarks) > 1000) {
            $filteredTrademarks = array_slice($filteredTrademarks, 0, 1000);
        }

        auth()->user()->decrement('remaining_bulletin_search_limit');

        $bulletins = Media::where('is_official', 1)->where('is_saved', 1)->orderBy('bulletin_no', 'desc')->take(5)->get();
        return view('dashboard.pages.search')
            ->with('bulletins', $bulletins)
            ->with('filteredTrademarks', $filteredTrademarks)
            ->with('searchedBulletin', $bulletin)
            ->with('keyword', $request->input('keyword'))
            ->with('classes', $request->input('classes'))
            ->with('exclusion_keywords', $request->input('exclusion_keywords'))
            ->with('time', $endTime - $startTime);
    }
}
