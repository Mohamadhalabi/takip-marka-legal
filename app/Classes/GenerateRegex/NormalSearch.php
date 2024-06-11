<?php

namespace App\Classes\GenerateRegex;

use App\Classes\TrademarkSearch;
use Illuminate\Support\Facades\Log;

class NormalSearch
{
    protected static $data;

    public function __construct($data)
    {
        self::$data = $data;
    }

    public static function createRegexGroup($char, $characters)
    {
        $str = '(';
        if (array_key_exists($char, $characters)) {
            $matchedCharacters = $characters[$char];
            foreach ($matchedCharacters as $matchedCharacter) {
                $str .= preg_quote($matchedCharacter) . '|';
            }
            $str = rtrim($str, '|');
        } else
            $str .= preg_quote($char, '/');
        $str .= ')';

        return $str;
    }

    public static function getRegex()
    {
        $characters = TrademarkSearch::$characters;
        $data = self::$data;
        $length = count($data['original']['splitted']);
        $splitted = $data['original']['splitted'];
        $keyword = $splitted;
        $convertLetter = true;
        if ($length == 1 || $length == 2) {
            $convertLetter = false;
            $keyword = preg_quote(implode('', $splitted));
        } else if ($length >= 6) {
            // get first 5 index
            $keyword = array_slice($splitted, 0, 6);
        }

        if ($convertLetter) {
            $regex = '';
            $counter = 1;
            foreach ($keyword as $index => $char) {
                // Named Tag
                if ($length >= 5 && !next($keyword)) {

                    if ($data['exactMatch']['contains']) {
                        if (!in_array($index, $data['exactMatch']['indexs'])) {
                            $lastChar = (isset($characters[preg_quote($char)])) ? self::createRegexGroup(preg_quote($char), $characters) : preg_quote($char);
                        }
                        else $lastChar = preg_quote($char);
                    }
                    else{
                        $lastChar = (isset($characters[preg_quote($char)])) ? self::createRegexGroup(preg_quote($char), $characters) : preg_quote($char);
                    }

                    $regex .= "(?<lastChar>($lastChar)?)";
                    break;
                }

                if ($index != 0) {
                    if ($data['exactMatch']['contains']) {
                        if (!in_array($index, $data['exactMatch']['indexs'])) {
                            $namedTag = '+(?<match' . $counter . '>[^\s]?)';
                        }
                        else $namedTag = '';
                    } else {
                        $namedTag = '+(?<match' . $counter . '>[^\s]?)';
                    }
                }

                // if exact match contains and index is in exact match indexs
                $regex .= $namedTag ?? '';
                if ($data['exactMatch']['contains'] && in_array($index, $data['exactMatch']['indexs'])) {
                    $regex .= "(?<c$index>".preg_quote($char).")";
                } else {
                    $regex .= "(?<c$index>".self::createRegexGroup($char, $characters).")";
                }

                $counter++;
            }
        }
        if ($length == 1 || $length == 2) {
            $regex = '(?<=\s|^)' . $keyword . '+(?=\s|$)';
        } else if ($length == 3) {
            $regex = '^.*\b[^\s]{0,3}' . $regex;
        }

        return $regex;
    }
}
