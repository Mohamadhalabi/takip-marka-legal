<?php

namespace App\Classes;

use App\Classes\GenerateRegex\NormalSearch;
use App\Classes\GenerateRegex\ReverseSearch;
use App\Classes\GenerateRegex\SearchBySpace;
use App\Models\Trademark;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrademarkSearch
{
    // Characters and equivalents to use in regex conversions.
    public static $characters = [
        'a' => ["A", "a"],
        'b' => ["B", "b", "D", "d", "P", "p"],
        'c' => ["Ç", "ç", "C", "c", "Ch", "ch", "CH", "cH", "K", "k"],
        'ç' => ["Ç", "ç", "C", "c", "Ch", "ch", "CH", "cH", "K", "k"],
        'd' => ["D", "d", "B", "b", "T", "t"],
        'e' => ["E", "e"],
        'f' => ["F", "f", "Ph", "ph", "PH", "pH"],
        'g' => ["Ğ", "ğ", "G", "g", "K", "k"],
        'ğ' => ["Ğ", "ğ", "G", "g", "K", "k"],
        'h' => ["H", "h"],
        'ı' => ["I", "ı", "İ", "i", "1", "Y", "y", "L", "l"],
        'i' => ["I", "ı", "İ", "i", "1", "Y", "y", "L", "l"],
        'l' => ["ı", "I", "i", "İ", "L", "l"],
        'j' => ["J", "j"],
        'k' => ["K", "k", "G", "g", "Ğ", "ğ", "C", "c"],
        'm' => ["M", "m", "Rn", "rN", "RN", "rn", "In", "IN", "ın", "ıN", "İn", "İN", "in", "iN"],
        'n' => ["N", "n"],
        'ö' => ["O", "o", "Ö", "ö", "0"],
        'o' => ["O", "o", "Ö", "ö", "0"],
        'p' => ["P", "p", "B", "b"],
        'r' => ["R", "r"],
        's' => ["S", "s", "Ş", "ş", "sh", "sH", "Sh", "SH", "5", "z", "Z"],
        'ş' => ["Ş", "ş", "S", "s", "sh", "sH", "Sh", "SH", "5", "z", "Z"],
        't' => ["T", "t", "D", "d"],
        'u' => ["U", "u", "Ü", "ü"],
        'ü' => ["Ü", "ü", "U", "u"],
        'v' => ["V", "v"],
        'y' => ["Y", "y", "I", "i", "ı", "İ"],
        'z' => ["Z", "z", "S", "s", "Ş", "ş", "5"],
        'w' => ["W", "w"],
        'x' => ["X", "x", "ks", "Ks", "kS", "KS"],
        'q' => ["Q", "q"],
        'plus' => ["artı", "arti", "+"],
        '0' => ["O", "o", "Ö", "ö", "0", "sifir", "sıfır", "zero"],
        '1' => ["1", "I", "ı", "İ", "i", "bir", "one"],
        '2' => ["2", "iki", "two"],
        '3' => ["3", "üç", "üc", "uc", "uch", "three"],
        '4' => ["4", "dört", "dort", "four"],
        '5' => ["5", "beş", "bes", "besh", "five", "s"],
        '6' => ["6", "altı", "alti", "six"],
        '7' => ["7", "yedı", "yedi", "seven"],
        '8' => ["8", "sekiz", "eight"],
        '9' => ["9", "dokuz", "nine"],
        '.' => [".", "nokta", "dot"],
    ];

    public static $scores = [
        "0" => [
            "b" => ["b"],
            "a" => ["a"],
            "c" => ["c"],
            "ç" => ["ç"],
            "d" => ["d"],
            "e" => ["e"],
            "f" => ["f"],
            "g" => ["g"],
            "ğ" => ["ğ"],
            "h" => ["h"],
            "ı" => ["ı"],
            "i" => ["i"],
            "j" => ["j"],
            "k" => ["k"],
            "l" => ["l"],
            "m" => ["m"],
            "n" => ["n"],
            "o" => ["o"],
            "ö" => ["ö"],
            "p" => ["p"],
            "r" => ["r"],
            "s" => ["s"],
            "ş" => ["ş"],
            "t" => ["t"],
            "u" => ["u"],
            "ü" => ["ü"],
            "v" => ["v"],
            "y" => ["y"],
            "z" => ["z"],
            "w" => ["w"],
            "x" => ["x"],
            "q" => ["q"],
        ],
        "0.25" => [
            "c" => ["ç"],
            "ç" => ["c", "ch"],
            "g" => ["ğ"],
            "ğ" => ["g"],
            "ı" => ["i"],
            "i" => ["ı"],
            "o" => ["ö"],
            "ö" => ["o"],
            "s" => ["ş"],
            "ş" => ["s", "sh"],
            "u" => ["ü"],
            "ü" => ["u"],
            "ch" => ["ç"],
            "f" => ["ph"],
            "ph" => ["f"],
            "x" => ["ks"],
            "ks" => ["x"],
            "sh" => ["ş"],
        ],
        "0.50" => [
            "b" => ["p"],
            "p" => ["b"],
            "c" => ["k", "ch"],
            "k" => ["c", "g", "ğ"],
            "d" => ["t"],
            "t" => ["d"],
            "g" => ["k"],
            "ğ" => ["k"],
            "i" => ["l", "y", "1"],
            "ı" => ["l", "y", "1"],
            "l" => ["i", "ı", "1"],
            "y" => ["i"],
            "s" => ["z", "5", "sh"],
            "z" => ["s"],
            "1" => ["ı", 'i', 'l'],
            "5" => ["s"],
            "ch" => ["c"],
            "sh" => ["s"],
            "o" => ["0"],
            "ö" => ["0"],
            "0" => ["o", "ö"],
        ],
        "0.75" => [
            "b" => ["d"],
            "d" => ["b"],
            "ç" => ["k"],
            "k" => ["ç"],
            "ı" => ["y"],
            "y" => ["ı"],
            "ş" => ["z", "5"],
            "z" => ["ş", "5"],
            "5" => ["ş", "z"],
        ],
        "1" => [
            "m" => ["rn", "in"],
            "rn" => ["m"],
            "in" => ["m"],
        ]
    ];

    // Characters and equivalents to use in regex conversions.
    public static $characters3lengths = [
        'a' => ["A", "a"],
        'b' => ["B", "b"],
        'c' => ["Ç", "ç", "C", "c", "Ch", "ch", "CH", "cH", "K", "k"],
        'ç' => ["Ç", "ç", "C", "c", "Ch", "ch", "CH", "cH", "K", "k"],
        'd' => ["D", "d", "T", "t"],
        'e' => ["E", "e"],
        'f' => ["F", "f", "Ph", "ph", "PH", "pH"],
        'g' => ["Ğ", "ğ", "G", "g", "K", "k"],
        'ğ' => ["Ğ", "ğ", "G", "g", "K", "k"],
        'h' => ["H", "h"],
        'ı' => ["I", "ı", "İ", "i", "1", "Y", "y"],
        'i' => ["I", "ı", "İ", "i", "1", "Y", "y"],
        'l' => ["ı", "I", "i", "İ", "L", "l", "R", "r"],
        'j' => ["J", "j"],
        'k' => ["K", "k", "G", "g", "Ğ", "ğ", "C", "c"],
        'm' => ["M", "m"],
        'n' => ["N", "n", "Rn", "rN", "RN", "rn", "In", "IN", "ın", "ıN", "İn", "İN", "in", "iN"],
        'ö' => ["O", "o", "Ö", "ö", "0"],
        'o' => ["O", "o", "Ö", "ö", "0"],
        'p' => ["P", "p", "B", "b"],
        'r' => ["R", "r"],
        's' => ["S", "s", "Ş", "ş", "sh", "sH", "Sh", "SH", "5", "z", "Z"],
        'ş' => ["Ş", "ş", "S", "s", "sh", "sH", "Sh", "SH", "5", "z", "Z"],
        't' => ["T", "t", "D", "d"],
        'u' => ["U", "u", "Ü", "ü"],
        'ü' => ["Ü", "ü", "U", "u"],
        'v' => ["V", "v"],
        'y' => ["Y", "y", "I", "i", "ı", "İ", "1"],
        'z' => ["Z", "z", "S", "s", "Ş", "ş", "sh", "sH", "Sh", "5"],
        'w' => ["W", "w"],
        'x' => ["X", "x", "ks", "Ks", "kS", "KS"],
        'q' => ["Q", "q"],
        '+' => ["artı", "arti", "+", "plus"],
        '0' => ["O", "o", "Ö", "ö", "0", "sifir", "sıfır", "zero"],
        '1' => ["1", "I", "ı", "İ", "i", "bir", "one"],
        '2' => ["2", "iki", "two"],
        '3' => ["3", "üç", "üc", "uc", "uch", "three"],
        '4' => ["4", "dört", "dort", "four"],
        '5' => ["5", "beş", "bes", "besh", "five", "s"],
        '6' => ["6", "altı", "alti", "six"],
        '7' => ["7", "yedı", "yedi", "seven"],
        '8' => ["8", "sekiz", "eight"],
        '9' => ["9", "dokuz", "nine"],
        '.' => [".", "nokta", "dot"],

    ];

    /**
     * Get cached trademarks
     *
     * @return array
     */
    public function getCachedTrademarks($bulletins, $type = 'generate-report')
    {
        $trademarks = Trademark::whereIn('bulletin_id', $bulletins)->get();

        return $trademarks;
    }

    /**
     * Get exploded data
     * Default seperator : '/'
     *
     * @param  mixed $string
     * @param  mixed $seperator
     * @return array
     */
    public function getExplodedData($string, $seperator = '/')
    {
        // Split string by separator
        $arr = explode($seperator, $string);

        // Remove spaces
        $arr = array_map('trim', $arr);

        // Remove empty values
        $arr = array_filter($arr);

        return $arr;
    }


    public function calculateSimilarity($s1, $s2)
    {
        $number = 1;
        switch (mb_strlen($s1)):
            case 3:
                $number = 1;
                break;
            case 4:
                $number = 1;
                break;
            case 5:
                $number = 2;
                break;
            case 6:
                $number = 2;
                break;
            case 7:
                $number = 2;
                break;
            case 8:
                $number = 3;
                break;
            default:
                return false;
        endswitch;

        $continue = false;

        // if (mb_strlen($s1) == 3 && mb_strlen($s2) == 3) {
        //     $continue = true;
        // }

        // if (mb_strlen($s1) == 4 && (mb_strlen($s2) == 4 || mb_strlen($s2) == 3)) {
        //     $continue = true;
        // }

        if (mb_strlen($s1) == 5 && (mb_strlen($s2) == 5 || mb_strlen($s2) == 6 || mb_strlen($s2) == 7)) {
            $continue = true;
        }

        if (mb_strlen($s1) == 6 && (mb_strlen($s2) == 5 || mb_strlen($s2) == 6 || mb_strlen($s2) == 7)) {
            $continue = true;
        }

        if (mb_strlen($s1) == 7 && (mb_strlen($s2) == 5 || mb_strlen($s2) == 6 || mb_strlen($s2) == 7 || mb_strlen($s2) == 8)) {
            $continue = true;
        }

        if (mb_strlen($s1) == 8 && (mb_strlen($s2) == 6 || mb_strlen($s2) == 7 || mb_strlen($s2) == 8 || mb_strlen($s2) == 9)) {
            $continue = true;
        }

        if (!$continue) {
            return false;
        }

        $s1Start = substr($s1, 0, $number);
        $s1End = substr($s1, -$number);
        $s2Start = substr($s2, 0, $number);
        $s2End = substr($s2, -$number);

        if ($s1Start == $s2Start && $s1End == $s2End) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if any of the nice classes match.
     *
     * @param  mixed $classes
     * @param  mixed $searchedClasses
     * @return boolean
     */
    public function isMatchedClasses(array $classes, array $searchedClasses)
    {
        // Check if any of the nice classes match
        $result = array_intersect($classes, $searchedClasses);

        return count($result) > 0 ? true : false;
    }

    /**
     * Get convension score of the 2 characters
     *
     * @param  mixed $s1
     * @param  mixed $s2
     * @return float
     */
    public static function getConversionScore($s1, $s2)
    {
        $scores = self::$scores;
        $convensionScore = 0;

        foreach ($scores as $key => $value) {
            if (array_key_exists($s1, $value)) {
                if (in_array($s2, $value[$s1])) {
                    return $key;
                }
            }
        }

        return $convensionScore;
    }

    /**
     * Create REGEX group
     *
     * @param  string $char
     * @return string $regexGroup
     */
    public function createRegexGroup($char)
    {
        $characters = $this->characters;
        $regexGroup = "";
        $regexGroup .= "(";
        if (array_key_exists($char, $characters)) {
            $regexGroup .= implode('|', $characters[$char]);
        } else $regexGroup = $char;
        $regexGroup .= ")";

        return $regexGroup;
    }

    public function createReverseRegexGroup($arr, $key)
    {
        $arr = array_unique($arr);
        $regexGroup = "";
        $regexGroup .= "(";

        foreach ($arr as $key => $value) {
            if (mb_strlen($value) > 1) {
                $tmp_arr = mb_str_split($value);
                $regexGroup .= "" . implode('|', $tmp_arr) . "|";
            }
        }
        $regexGroup .= implode('|', $arr);
        $regexGroup .= ")";

        return $regexGroup;
    }

    /**
     * Get all reverse characters
     *
     * @return array
     */
    public function reverseCharacters($keywordSimplifiedLen = 0)
    {
        $characters = ($keywordSimplifiedLen == 3) ? $this->characters3lengths : $this->characters;
        $values = array_reduce($characters, function ($carry, $item) {
            return array_merge($carry, $item);
        }, []);

        $reverseCharacters = [];
        foreach ($values as $value) {
            $reverseCharacters[$value] = $this->getReverseCharacters($value, $keywordSimplifiedLen);
        }
        return $reverseCharacters;
    }

    /**
     * Get values of reverse character
     *
     * @param  mixed $str
     * @return array
     */
    public function getReverseCharacters($str, $keywordSimplifiedLen = 0)
    {
        $characters = ($keywordSimplifiedLen == 3) ? self::$characters3lengths : self::$characters;

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
        } else $chars = $str;

        if (!array_key_exists($str, $chars)) {
            $chars[] = $str;
        }

        return $chars;
    }

    /**
     * Create reverse regex
     *
     * @param  mixed $keyword
     * @return string
     */
    public function getReverseRegex($keyword, $keywordSimplifiedLen = 0)
    {
        if (Cache::has('reverseKeys')) {
            $reverseKeys = Cache::get('reverseKeys');
        } else {
            $reverseKeys = array_keys($this->reverseCharacters($keywordSimplifiedLen));
            Cache::put('reverseKeys', $reverseKeys);
        }
        usort($reverseKeys, function ($a, $b) {
            return strlen($b) - strlen($a);
        });
        $groups = [];
        $counter = 1;
        $reverseKeys = array_filter($reverseKeys, function ($val) {
            return !is_numeric($val);
        });
        $reverseKeys = array_values($reverseKeys);

        if (str_contains($keyword, '.')) {
            $keyword = str_replace('.', '[' . $counter . ']', $keyword);
            $groups[$counter] = '(\.)';
            $counter++;
        }
        foreach ($reverseKeys as $key) {
            if (str_contains($keyword, $key)) {
                $chars = $this->getReverseCharacters($key, $keywordSimplifiedLen);
                $group = $this->createReverseRegexGroup($chars, $key);
                $groups[$counter] = $group;
                $keyword = str_replace($key, '[' . $counter . ']', $keyword);
                $counter++;
            }
        }

        foreach ($groups as $key => $group) {
            $keyword = str_replace('[' . $key . ']', $group, $keyword);
        };
        return $keyword;
    }

    /**
     * Convert the word to lower case in accordance with the Turkish alphabet.
     * intl extension needs to be active.
     * Windows : https://stackoverflow.com/questions/33869521/how-can-i-enable-php-extension-intl
     * Linux : https://stackoverflow.com/questions/42243461/how-to-install-php-intl-extension-in-ubuntu-14-04
     *
     * @param  mixed $string
     * @return string
     */
    public function str2lower($string)
    {
        // Convert the word to lower case in accordance with the Turkish alphabet.
        return \Transliterator::create("tr-Lower")->transliterate($string);
    }

    /**
     * The rules of how many matches will be returned according to the number of words are specified.
     *
     * @param  mixed $wordCount
     * @param  mixed $counter
     * @return boolean
     */
    public function matchingWordCountRules(int $wordCount, int $counter)
    {
        switch ($wordCount) {
            case 0:
                return false;
            case 1:
                return $counter == 1 ? true : false;
            case 2:
                return $counter == 2 ? true : false;
            case 3:
                return $counter >= 2 ? true : false;
            case 4:
                return $counter >= 2 ? true : false;
            case 5:
                return $counter >= 3 ? true : false;
            case 6:
                return $counter >= 3 ? true : false;
            case 7:
                return $counter >= 3 ? true : false;
            case 8:
                return $counter >= 3 ? true : false;
            default:
                return false;
        }
    }

    /**
     * Configures the regex.
     *
     * @param  mixed $rules
     * @param  mixed $keyword"
     * @return string
     */
    public function searchRules($keyword, array $rules = [])
    {
        $quoted = false;
        $start = 0;
        $end = 0;
        $fragmentOriginalLength = mb_strlen($keyword);
        // keyword u separate word by word. If it's in quotation marks, specify $quoted = 1, otherwise $quoted = 0 and send it to the array.
        $quoted = false;
        if (preg_match('/"/', $keyword)) {
            $start = mb_strpos($keyword, '"');
            $end = mb_strpos($keyword, '"', $start + 1);
            $word = mb_substr($keyword, $start + 1, $end - $start - 1);
            $quoted = true;
        }

        $letterCount = mb_strlen($keyword);
        $keywordSimplified = $str = preg_replace("/(.)\\1+/", "$1", $keyword);
        $convertLetters = false;
        $reverseRegex = $this->getReverseRegex($keyword, mb_strlen($keywordSimplified));

        // get groups
        $output = preg_match_all('/\((.*?)\)/', $reverseRegex, $matches);
        // return $matches;
        $reverseRegex = $matches[0];
        if ($letterCount == 1 || $letterCount == 2) {
            $convertLetters = false;
        } else if ($letterCount == 3) {
            $convertLetters = true;
        } else if ($letterCount >= 4 && $letterCount <= 5) {
            // remove the last letter and give the word
            // if (!$quoted) {
            //      $keyword = mb_substr($keyword, 0, -1);
            // }
            $convertLetters = true;
        } else if ($letterCount >= 6) {
            // get first 5 letter
            if (!$quoted) {
                $keyword = mb_substr($keyword, 0, 6);
            }
            $convertLetters = true;
        }
        // Default regex
        $reverseRegex = str_replace('.', "\\.", $reverseRegex);
        $regex = str_replace('.', "\\.", $keyword);
        $tmp_reverse_arr = [];
        $lastElement = "";
        $currentElement = "";
        foreach ($reverseRegex as $key => $regex) {
            $currentElement = $regex;
            if ($key == 0) {
                $lastElement = $currentElement;
                $tmp_reverse_arr[$key] = $regex;
                continue;
            }
            if ($lastElement != $currentElement && $key != 0) {
                $tmp_reverse_arr[$key] = $regex;
            }
            $lastElement = $currentElement;
        }

        // Reverse Search Regex
        $reverseRegex = $tmp_reverse_arr;
        $newReverseRegex = array_slice($reverseRegex, 0, mb_strlen($keyword));
        $regexReverse = "";
        $reverseRegexLength = count($newReverseRegex);
        $numItems = count($newReverseRegex);
        $i = 0;
        foreach ($newReverseRegex as $key => $reverseRegexGroup) {
            $filterAnyChar = str_replace(array('(', ')', '|'), '', $reverseRegexGroup);

            if (++$i === $numItems && $reverseRegexLength != 1) {
                $matchString = "+(?<rLastChar>)";
            } else if ($key == 0) {
                $matchString = "";
            } else {
                $matchString = "+(?<rMatch$key>[^\s]?)";
            }
            $regexReverse .= $matchString . $reverseRegexGroup;
        }
        if ($reverseRegexLength == 1) {
            $regexReverse = '(?<=\s|^)' . $regexReverse . '+(?=\s|$)';
        } else if ($reverseRegexLength == 2) {
            $regexReverse = '(?<=\s|^)' . $regexReverse;
        } else if ($reverseRegexLength == 3) {
            $regexReverse = '^.*\b[^\s]{0,3}' . $regexReverse;
        } else if ($reverseRegexLength == 4) {
            // $regexReverse = "len4";
        } else if ($reverseRegexLength == 5) {
            // $regexReverse = "len5";
        } else if ($reverseRegexLength >= 6) {
            // $regexReverse = "len6";
        } else {
        }
        // Rule applied for 1 and 2 character keywords
        if ($letterCount == 1 || $letterCount == 2) {
            // Block suffix and prefix
            $keyword =  '(?<=\s|^)' . $keyword . '+(?=\s|$)';

            // replace . to \. in keyword
            // $newReverseRegex = '(?<=\s|^)' . str_replace('.', '\.', $newReverseRegex) . '+(?=\s|$)';
            $regex = str_replace('.', '\.', $keyword);
        }
        // Rule applied for len=>3 character keywords
        if ($convertLetters) {
            // Split keyword
            $chars = mb_str_split($keyword);
            $str = '';

            $characters = $this->characters;
            $counter = 0;
            foreach ($chars as $key => $char) {
                $appendText = '';
                if ($fragmentOriginalLength >= 5 && !next($chars)) {
                    if (isset($characters[$char])) {
                        $lastChar = $this->createRegexGroup($char);
                    } else $lastChar = $char;
                    $str .= "(?<lastChar>$lastChar?)";
                    break;
                }
                // if array not first and last element
                if ($key != 0 && $quoted == false) {
                    $appendText = '+(?<match' . $counter . '>[^\s]?)';
                }

                if (isset($characters[$char]) && !($key >= $start && $key <= $end - 1)) {
                    if ($key != 0 && $quoted == true && ($key <= $start || $key >= $end - 1)) {
                        $appendText = '+(?<match' . $counter . '>[^\s]?)';
                    }
                    $str .= $appendText . $this->createRegexGroup($char);
                } else $str .= $appendText . $char;

                $counter++;
            }
            $keyword = str_replace('.', "\\.", $keyword);
            // Regex with spaces
            $regexWithSpaces = mb_str_split($keyword);
            $regexWithSpaces = array_map(function ($char) {
                if ($char == '.') return '(\\.)';
                return $char;
            }, $regexWithSpaces);
            $strWithSpaces = '';

            foreach ($regexWithSpaces as $regexWithChar) {
                $tmp_group = (isset($characters[$regexWithChar])) ? $this->createRegexGroup($regexWithChar) : $regexWithChar;
                $strWithSpaces .= $tmp_group . ' ';
            }
            // Trim last space
            $strWithSpaces = trim($strWithSpaces);
            if ($letterCount == 3) {
                $str = '^.*\b[^\s]{0,3}' . $str;
            }
            // replace " to '
            $str = str_replace('"', '', $str);

            $regex = $str;
        }
        // Create final regex
        $finalRegex = '';
        $finalRegex .= '(' . $regex . ')';
        $finalRegex .= '|(' . $regexReverse . ')';
        $finalRegex .= (isset($strWithSpaces)) ? '|(' . $strWithSpaces . ')' : '';
        $data = [
            'regex' => $regex,
            'regexReverse' => $regexReverse ?? '',
            'regexWithSpaces' => (isset($strWithSpaces)) ? $strWithSpaces : '',
            'info' => [
                'regexLenght' => $letterCount,
                'reverseRegexLength' => $reverseRegexLength,
            ]
        ];

        return $data;
    }

    public static function searchWithRegex($keyword, $trademark, $searchedClasses, $search, $exclusion_keywords)
    {
        // Get word count
        $wordCount = count($keyword['fragments']);

        // Check that the trademark contains the sought nice classes and that the sought nice classes are not empty.
        if ($search->isMatchedClasses($search->getExplodedData($trademark['nice_classes'] ?? ''), $searchedClasses) || count($searchedClasses) == 0) {
            // Start counter
            $counter = 0;
            $reverseCounter = 0;
            $regexWithSpacesCounter = 0;
            // Matched fragments
            $matchedFragments = [];
            $highlights = [];
            $normalScore = 0;
            $reverseScore = 0;
            // Loop all words belonging to keyword
            foreach ($keyword['fragments'] as $key => $fragment) {
                // Create the regex according to the desired word and rules
                // Exact Match Position an indexs
                $exactMatchToken = '"';
                if (str_contains($fragment, $exactMatchToken)) {
                    //Delete the $exactMatchToken character from $keyword and give the starting and ending index of the characters in between
                    $exactMatchPosition = [];
                    $exactMatchPosition['start'] = mb_strpos($fragment, $exactMatchToken);
                    $exactMatchPosition['end'] = mb_strrpos($fragment, $exactMatchToken);

                    $removedExactMatchToken = preg_replace('/"/', '', $fragment);

                    for ($i = $exactMatchPosition['start']; $i <= $exactMatchPosition['end'] - 2; $i++) {
                        $exactMatchIndexs[] = $i;
                    }

                    // Find all $exactMatchToken position and give the characters between them
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

                $data = [
                    "exactMatch" => $exactMatchPosition,
                    "original" => [
                        "value" => $fragment,
                        "length" => mb_strlen($fragment),
                        "splitted" => mb_str_split(preg_replace('/"/', '', $fragment)),
                    ],
                ];
                $normalSearch = new NormalSearch($data);
                $reverseSearch = new ReverseSearch($data);
                $searchBySpace = new SearchBySpace($data);
                $data = [
                    'regex' => $normalSearch->getRegex(),
                    'reverseRegex' => $reverseSearch->getRegex(),
                    'regexWithSpaces' => $searchBySpace->getRegex(),
                ];
                // Log::channel('monitor')->info($data);
                // return $data;
                $regex = $data['regex'];
                $regexReverse = $data['reverseRegex']['regex'];
                $regexWithSpaces = $data['regexWithSpaces'];
                // Query regex in $trademark['name']
                // Punctuation marks and the characters to convert.
                $replace = [
                    ' ' => ' ',
                    //'-' => '', // remove punctuation
                    //'.' => '', // remove punctuation
                    // ',' => '',
                    '/' => '',
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

                // $regex = $data['regex'];
                // $regexReverse = $data['regexReverse'];
                // $regexWithSpaces = $data['regexWithSpaces'];
                $string = strtr($trademark['name'], $replace);
                /**
                 * * Normal Search
                 */
                if (preg_match("/\b\w*$regex\w*\b/iu", $string, $matches)) {
                    // Log::channel('monitor')->info("\b\w*$regex\w*\b");
                    // Log::channel('monitor')->info("\b\w*$regex\w*\b");
                    // Log::channel('monitor')->info($matches);
                    $hl = preg_match("/$regex/iu", $string, $normalHl);
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

                    $fragment_splitted = mb_str_split($fragment);
                    $transforms = [];
                    $totalConversionScore = 0;
                    foreach ($chars as $index => $char) {
                        $transforms[] = [
                            'from' => $fragment_splitted[$index],
                            'to' => $char,
                            'transform' => ($fragment_splitted[$index] == $char) ? 'same' : 'different',
                        ];

                        $totalConversionScore += self::getConversionScore($fragment_splitted[$index], $char);
                    }
                    $totalConversionScore += $matchCounter * 1;
                    $normalScore = $totalConversionScore;
                    $differentChars = array_filter($transforms, function ($transform) {
                        return $transform['transform'] == 'different';
                    });
                    $matchedString = $matches[0] ?? '';
                    $charCount = mb_strlen($fragment);

                    // Check if last character exists
                    $lastCharacter = $matches['lastChar'] ?? '';
                    $hasLastChar = ($lastCharacter != '') ? true : false;

                    $exclusionMatch = false;
                    try {
                        if($exclusion_keywords != null){
                            foreach ($exclusion_keywords as $exclusionKeyword) {
                                if (str_contains($matchedString, $exclusionKeyword)) {
                                    $exclusionMatch = true;
                                    break;
                                }
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
                    if ($totalConversionScore > 1.50) {
                        Log::channel('regex')->info("Normal Search - Keyword: " . $fragment . " - " . $matchedString . " - " . $totalConversionScore);
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
                        if(mb_strlen($matches[0]) <= 4){
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
                if (preg_match("/\b\w*$regexReverse\w*\b/iu", $string, $reverseMatches)) {
                    // Log::channel('monitor')->info("\b\w*$regexReverse\w*\b");
                    $rhl = preg_match("/$regexReverse/iu", $string, $reverseHighlight);
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
                    $r_fragment_splitted = mb_str_split($fragment);
                    $rTransforms = [];
                    foreach ($rChars as $rIndex => $rChar) {
                        $rTransforms[] = [
                            'from' => $r_fragment_splitted[$rIndex],
                            'to' => $rChar,
                            'transform' => ($r_fragment_splitted[$rIndex] == $rChar) ? 'same' : 'different',
                        ];
                        $rTotalConversionScore += self::getConversionScore($r_fragment_splitted[$rIndex], $rChar) * 1;
                    }
                    // Log::channel('monitor')->info($rTransforms);
                    $rTotalConversionScore += $c * 1;
                    $reverseScore = $rTotalConversionScore;
                    $rDifferentChars = array_filter($rTransforms, function ($rTransform) {
                        return $rTransform['transform'] == 'different';
                    });

                    $reverseCharCount = $data['reverseRegex']['length'];
                    $reverseLastCharacter = $reverseMatches['rLastChar'] ?? '';
                    $reverseHasLastChar = ($reverseLastCharacter != '') ? true : false;
                    $matchedReverseString = $reverseMatches[0] ?? '';

                    $exclusionReverseMatch = false;
                    try {
                        if($exclusion_keywords != null){
                            foreach ($exclusion_keywords as $exclusionKeyword) {
                                if (str_contains($matchedReverseString, $exclusionKeyword)) {
                                    $exclusionReverseMatch = true;
                                    break;
                                }
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
                    // if ($search->matchingWordCountRules($wordCount, $counter) === false && $reverseCharCount >= 3) {

                    if ($rTotalConversionScore > 1.50) {
                        Log::channel('regex')->info("Reverse Search - Keyword: " . $fragment . " - " . $matchedReverseString . " - " . $rTotalConversionScore);
                    }
                    if (1 == 1) { // TODO : should it be here
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
                }
            }
            if ($matchedFragments) {
                // Add a new field to the filtered trademark and save the matching words.
                $trademark['_filtered'] = [
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
            if ($search->matchingWordCountRules($wordCount, $reverseCounter) || $search->matchingWordCountRules($wordCount, $counter) || $regexWithSpacesCounter) {
                return $trademark;
            }else {
                $status = $search->calculateSimilarity($fragment, $string);
                if ($status) {
                    Log::channel('monitor')->info($trademark->bulletin->bulletin_no.' | '.$fragment. " | " . $string);
                    return $trademark;
                }
            }
        }
    }

    /**
     * Filter trademarks.
     *
     * @param string $string
     * @return array
     */
    public function filteredTrademarks($trademarks, $searchedClasses, $keyword, $search, $exclusion_keywords)
    {
        ini_set('max_execution_time', 180);
        ini_set('memory_limit', '512M');
        $filteredTrademarks = [];
        foreach ($trademarks as $trademark) {
            $response = self::searchWithRegex($keyword, $trademark, $searchedClasses, $search, $exclusion_keywords);
            unset($trademarks[$trademark->id]);
            if ($response != null) {
                $filteredTrademarks[] = $response;
            }
        }

        return $filteredTrademarks;
    }
}
