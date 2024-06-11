<?php

namespace App\Classes\GenerateRegex;

use App\Classes\TrademarkSearch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ReverseSearch
{
    protected static $data;

    public function __construct($data)
    {
        self::$data = $data;
    }

    public static function createReverseRegexGroup($arr, $key)
    {
        $arr = array_unique($arr);
        $regexGroup = "";
        $regexGroup .= "(";

        foreach ($arr as $key => $value) {
            $value = preg_quote($value);
            if (mb_strlen($value) > 1 && mb_strlen($value) < 2) {
                $tmp_arr = mb_str_split($value);
                $regexGroup .= "" . implode('|', $tmp_arr) . "|";
            } else {
                $regexGroup .= $value . "|";
            }
        }
        $regexGroup = rtrim($regexGroup, '|');
        $regexGroup .= ")";

        return $regexGroup;
    }

    /**
     * Get values of reverse character
     *
     * @param  mixed $str
     * @return array
     */
    public static function getReverseCharacters($str, $keywordSimplifiedLen = 0)
    {
        $characters = ($keywordSimplifiedLen == 3) ? TrademarkSearch::$characters3lengths : TrademarkSearch::$characters;

        foreach ($characters as $key => $value) {
            foreach ($value as $v) {
                if (!isset($reverseChar[$v])) {
                    $reverseChar[$v] = [];
                }
                $reverseChar[$v][] = $key;
            }
        }

        if (array_key_exists($str, $reverseChar)) {
            $chars = $reverseChar[$str];
        } else $chars = [$str];

        if (!array_key_exists($str, $chars)) {
            $chars[] = $str;
        }

        return $chars;
    }

    /**
     * Get all reverse characters
     *
     * @return array
     */
    public static function reverseCharacters($keywordSimplifiedLen = 0)
    {
        $characters = ($keywordSimplifiedLen == 3) ? TrademarkSearch::$characters3lengths : TrademarkSearch::$characters;
        $values = array_reduce($characters, function ($carry, $item) {
            return array_merge($carry, $item);
        }, []);

        $reverseCharacters = [];
        foreach ($values as $value) {
            $reverseCharacters[$value] = self::getReverseCharacters($value, $keywordSimplifiedLen);
        }
        return $reverseCharacters;
    }

    /**
     * Create reverse regex
     *
     * @param  mixed $keyword
     * @return string
     */
    public static function getReverseRegex($string, $keywordSimplifiedLen = 0, $exactMatchValue = '')
    {
        if ($keywordSimplifiedLen == 3) {
            if (!Cache::has('reverse_regex_3')) {
                $reverseKeys = array_keys(self::reverseCharacters($keywordSimplifiedLen));
                usort($reverseKeys, function ($a, $b) {
                    return mb_strlen($b) - mb_strlen($a);
                });
                $reverseKeys = array_values($reverseKeys);

                Cache::put('reverse_regex_3', $reverseKeys, 60 * 24 * 30);
            } else {
                $reverseKeys = Cache::get('reverse_regex_3');
            }
        } else {
            if (!Cache::has('reverse_regex')) {
                $reverseKeys = array_keys(self::reverseCharacters($keywordSimplifiedLen));
                usort($reverseKeys, function ($a, $b) {
                    return mb_strlen($b) - mb_strlen($a);
                });
                $reverseKeys = array_values($reverseKeys);
                Cache::put('reverse_regex', $reverseKeys, 60 * 24 * 30);
            } else {
                $reverseKeys = Cache::get('reverse_regex');
            }
        }

        $counter = 0;
        // $groups = [];
        $splittedString = mb_str_split($string);
        $exactCharc = ['[', ']'];
        $counter = 0;
        $stringIndexes = [];
        foreach ($reverseKeys as $reverseKeyIndex => $reverseKey) {
            if (str_contains($string, $reverseKey)) {
                $index = array_search($reverseKey, $splittedString);
                $left = $splittedString[$index - 1] ?? '';
                $right = $splittedString[$index + 1] ?? '';
                if (in_array($splittedString[$index], $exactCharc)) continue;
                if ($reverseKey == 'E' && $right == ']' && $left == '[') {
                    // $groups[] = [$counter => $exactMatchValue];
                    $split = mb_str_split($exactMatchValue);
                    $tmp_string = "";
                    foreach ($split as $s) {
                        $tmp_string .= "(" . preg_quote($s) . ")";
                    }
                    $stringIndexes[] = [
                        'index' => $index,
                        'key' => $reverseKey,
                        'group' => $tmp_string,
                    ];
                    // $counter++;
                    continue;
                }
                $chars = self::getReverseCharacters($reverseKey, $keywordSimplifiedLen);
                $group = self::createReverseRegexGroup($chars, $reverseKey);

                $offset = 0;
                $needle = $reverseKey;
                while (($index = mb_strpos($string, $needle, $offset)) !== false) {
                    $stringIndexes[] = [
                        'index' => $index,
                        'key' => $reverseKey,
                        'group' => $group,
                    ];
                    $offset = $index + 1;
                }

                // $groups[] = [$counter => $group];
                $counter++;
            }
        }
        // sort by index
        usort($stringIndexes, function ($a, $b) {
            return $a['index'] <=> $b['index'];
        });

        // filter same index
        $stringIndexes = array_filter($stringIndexes, function ($item, $key) use ($stringIndexes) {
            if ($key == 0) return true;
            if ($item['index'] == $stringIndexes[$key - 1]['index']) return false;
            return true;
        }, ARRAY_FILTER_USE_BOTH);


        $newRegexString = '';

        $nextIndex = 0;
        $stringIndexes = array_values($stringIndexes);

        foreach ($stringIndexes as $index => $item) {
            $itemLen = mb_strlen($item['key']);

            if ($index == 0) {
                $newRegexString .=  $item['group'];
                $nextIndex = $index + $itemLen;
            }

            // return $nextIndex;
            if ($index == $nextIndex) {
                $newRegexString .=  $item['group'];
                $nextIndex = $index + $itemLen;
            }
        }

        return $newRegexString;
    }

    public static function getRegex()
    {
        $data = self::$data;
        $length = count($data['original']['splitted']);
        $characters = ($length == 3) ? TrademarkSearch::$characters3lengths : TrademarkSearch::$characters;
        $splitted = $data['original']['splitted'];
        $keyword = $splitted;
        $tmp_reverse_arr = [];
        $lastElement = "";
        $currentElement = "";
        // Simplified keyword
        foreach ($splitted as $key => $value) {
            $currentElement = $value;
            if ($key == 0) {
                $lastElement = $currentElement;
                $tmp_reverse_arr[$key] = $value;
                continue;
            }
            if ($data['exactMatch']['contains']) {
                if (in_array($key, $data['exactMatch']['indexs'])) {
                    $tmp_reverse_arr[$key] = $value;
                } else {
                    if ($lastElement != $currentElement && $key != 0) {
                        $tmp_reverse_arr[$key] = $value;
                    }
                }
            } else {
                if ($lastElement != $currentElement && $key != 0) {
                    $tmp_reverse_arr[$key] = $value;
                }
            }
            $lastElement = $currentElement;
        }
        $reverseRegexCharacters = array_slice($tmp_reverse_arr, 0, 6, true);
        $string = implode("", $reverseRegexCharacters);
        // Get exact match string
        if ($data['exactMatch']['contains']) {
            $indexs = $data['exactMatch']['indexs'];
            $exactMatchString = "";
            foreach ($indexs as $index) {
                $exactMatchString .= $keyword[$index];
            }
            $string = preg_replace('/' . $exactMatchString . '/', '[E]', $string, 1);
        }

        $keywordSimplifiedLen = count($reverseRegexCharacters);
        $reverseRegexGroups = self::getReverseRegex($string, $keywordSimplifiedLen,$data['exactMatch']['value'] ?? null);
        $groups = preg_match_all('/\((.*?)\)|\[(.*?)\]/', $reverseRegexGroups, $matches);
        $reverseRegexArr = $matches[0];
        // return $reverseRegexArr;
        $reverseLength = count($reverseRegexArr);
        // return $reverseLength;
        // Log::channel('monitor')->info($reverseRegexGroups);

        $regex = "";
        $suffix = "";
        $i = 0;
        foreach ($reverseRegexArr as $key => $reverseRegexGroup) {
            $matchString = "";
            $rLastChar = "";
            $suffix = "";
            // if last loop
            if ($i == $reverseLength - 1 && $reverseLength != 1 && $reverseLength >= 5) {
                $rLastChar = "+(?<rLastChar>($reverseRegexGroup)?)";
                $reverseRegexGroup = "";
            } else if ($key == 0) {
                $matchString = "";
            } else {
                $matchString = "+(?<rMatch$key>[^\s]?)";
            }
            $i++;
            if($reverseRegexGroup != ""){
                $regex .= $matchString . "(?<c$key>" . $reverseRegexGroup . "$suffix)".$rLastChar;
            }
            else{
                $regex .= $matchString . $reverseRegexGroup . "$suffix".$rLastChar;
            }
        }
        $regex = ltrim($regex, '+');
        // return $regex;
        if ($reverseLength == 1) {
            $regex = '(?<=\s|^)' . $regex . '+(?=\s|$)';
        } else if ($reverseLength == 2) {
            $regex = '(?<=\s|^)' . $regex . '\w{0,3}';
        } else if ($reverseLength == 3) {
            $regex = '^.*\b[^\s]{0,3}' . $regex;
        }

        $data = [
            'regex' => $regex,
            'length' => $reverseLength,
        ];

        return $data;
    }
}
