<?php

namespace App\Classes\GenerateRegex;

use App\Classes\TrademarkSearch;

class SearchBySpace
{
    protected static $data;

    public function __construct($data)
    {
        self::$data = $data;
    }

    public static function createRegexGroup($char, $characters)
    {
        $str = '(';
        if(array_key_exists($char, $characters))
            $str .= implode('|', $characters[$char]);
        else
            $str .= $char;
        $str .= ')';

        return $str;
    }

    public static function getRegex()
    {
        $characters = TrademarkSearch::$characters;
        $fragment = self::$data['original']['splitted'];

        $regex = '';
        foreach ($fragment as $char) {
            $space = "(\.|\s|\-)";
            $regex .= self::createRegexGroup(preg_quote($char), $characters);
            // if loop is not last
            if (next($fragment) !== false) {
                $regex .= $space;
            }
        }
        return $regex;
    }
}
