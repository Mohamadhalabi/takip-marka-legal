<?php

if (!function_exists('unescapeToString')) {
    function unescapeToString($str)
    {
        $json = sprintf('"%s"', $str); # build json string
        $utf8_str = json_decode($json, true); # json decode
        return $utf8_str;
    }
}

if (!function_exists('replaceLastSlash')) {
    function replaceLastSlash($string, $replacement = '_')
    {
        $position = strrpos($string, "/");

        if ($position !== false) {
            $string = substr_replace($string, $replacement, $position, 1);
        }

        return $string;
    }
}

if (!function_exists('truncateText')) {
    function truncateText($text, $length = 35, $suffix = '...')
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length) . $suffix;
    }
}
