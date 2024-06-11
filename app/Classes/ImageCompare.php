<?php

namespace App\Classes;

use Intervention\Image\ImageManagerStatic as Image;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\PerceptualHash;

class ImageCompare
{
    public function getPath($path)
    {
        $image_path = storage_path('app/public/' . $path);

        return $image_path;
    }

    /**
     * getDominantColors
     *
     * @param  string  $path
     * @param  int  $limit
     * @return array
     */
    public function getDominantColors($path, $limit = 3)
    {
        $ex = new Colors();
        $colors = $ex->Get_Color($path, 10, true, true, 24);
        return array_slice($colors, 0, $limit);
    }

    /**
     * calculateHexSimilarity
     *
     * @param  mixed  $hex1
     * @param  mixed  $hex2
     * @return void
     */
    public function calculateHexSimilarity($hex1, $hex2)
    {
        // Convert the hex codes to RGB values.
        $r1 = hexdec(substr($hex1, 1, 2));
        $g1 = hexdec(substr($hex1, 3, 2));
        $b1 = hexdec(substr($hex1, 5, 2));
        $r2 = hexdec(substr($hex2, 1, 2));
        $g2 = hexdec(substr($hex2, 3, 2));
        $b2 = hexdec(substr($hex2, 5, 2));

        // Calculate the distance between the RGB values.
        $dR = abs($r1 - $r2);
        $dG = abs($g1 - $g2);
        $dB = abs($b1 - $b2);

        // Calculate the similarity ratio.
        $sr = (1 - $dR / 255) * (1 - $dG / 255) * (1 - $dB / 255);

        return number_format($sr * 100, 2);
    }

    /**
     * Get the value of phash
     *
     * @param  mixed  $path
     * @return void
     */
    public function getPHash($path)
    {
        $hasher = new ImageHash(new PerceptualHash());
        $hash = $hasher->hash($path);
        $phash_str = strval($hash);

        return $phash_str;
    }

    public function getHistogram($path)
    {
        try {
            $img = imagecreatefromjpeg($path);
        } catch (\Throwable $th) {
            return false;
        }
        $width = imagesx($img);
        $height = imagesy($img);

        $hist = array_fill(0, 256, 0);

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $red = ($rgb >> 16) & 0xFF;
                $green = ($rgb >> 8) & 0xFF;
                $blue = $rgb & 0xFF;
                $gray = round(($red + $green + $blue) / 3);
                $hist[$gray]++;
            }
        }

        $hist_json = json_encode($hist);

        return $hist_json;
    }

    public function comparePHash($phash1, $phash2)
    {
        $len = strlen($phash1);
        $difference = 0;

        for ($i = 0; $i < $len; $i++) {
            $difference += intval($phash1[$i], 16) - intval($phash2[$i], 16);
        }

        $similarity = (1 - $difference / $len ** 2) * 100;
        $response = [
            'phash1' => $phash1,
            'phash2' => $phash2,
            'similarity' => $similarity,
        ];

        return $response;
    }

    /**
     * compareHistogram
     *
     * @param  mixed  $hist1
     * @param  mixed  $hist2
     * @return void
     */
    public function compareHistogram($hist1, $hist2)
    {
        $n = count($hist1);

        $sum1 = array_sum($hist1);
        $sum2 = array_sum($hist2);

        $sum1Sq = 0;
        $sum2Sq = 0;
        $pSum = 0;

        for ($i = 0; $i < $n; $i++) {
            $x = $hist1[$i] / $sum1;
            $y = $hist2[$i] / $sum2;

            $sum1Sq += $x * $x;
            $sum2Sq += $y * $y;
            $pSum += $x * $y;
        }

        $numerator = $pSum - ($sum1 * $sum2) / $n;
        $denominator = sqrt(
            ($sum1Sq - ($sum1 * $sum1) / $n) * ($sum2Sq - ($sum2 * $sum2) / $n)
        );

        if ($denominator == 0) {
            return 0;
        }

        return $numerator / $denominator;
    }

    public function phashSimilarity($image1, $image2)
    {
        $binary1 = hex2bin($image1->phash);
        $binary2 = hex2bin($image2->phash);
        $distance = 0;
        for ($i = 0; $i < strlen($binary1); $i++) {
            // Calculate the bit difference using XOR
            $difference = ord($binary1[$i]) ^ ord($binary2[$i]);

            // Count the number of set bits (1s) in the difference
            while ($difference > 0) {
                $distance += $difference & 1;
                $difference >>= 1;
            }
        }
        $hashLength = strlen($binary1) * 8; // 8 bits per byte
        $similarityRatio = (1 - ($distance / $hashLength)) * 100;

        return $similarityRatio;
    }

    /**
     * colorSimilarity
     *
     * @param  mixed $image1 User Image
     * @param  mixed $image2 Trademark
     * @return void
     */
    public function colorSimilarity($image1, $image2)
    {
        $color_similarity = [];
        $image1->dominant_colors = $image1->dominant_colors;
        $image2->dominant_colors = $image2->dominant_colors;
        foreach ($image1->dominant_colors as $key => $color) {
            foreach ($image2->dominant_colors as $key2 => $color2) {
                // eğer beyaz ve ya siyahsa sayma
                try {
                    $color = '#' . $color->hex;
                } catch (\Throwable $th) {
                    $color = $color;
                }
                $color2Hex = '#' . $color2->hex;
                if ($color2 == '#ffffff' || $color2 == '#000000') {
                    continue;
                }
                // RGB değerlerini alalım

                $red = hexdec(substr($color2Hex, 1, 2));
                $green = hexdec(substr($color2Hex, 3, 2));
                $blue = hexdec(substr($color2Hex, 5, 2));


                $treshold = 20;
                // eğer renkler birbirine çok yakınsa sayma
                if ($red >= (255 - $treshold) && $green >= (255 - $treshold) && $blue >= (255 - $treshold)) {
                    continue;
                }
                $color_compare = [
                    'color' => $color,
                    'color2' => $color2Hex,
                    'similarity' => $this->calculateHexSimilarity($color, $color2Hex),
                ];

                array_push($color_similarity, $color_compare);

                // $color_similarity array ını similarity değerine göre sırala
                usort($color_similarity, function ($a, $b) {
                    return $b['similarity'] <=> $a['similarity'];
                });
            }
        }
        return $color_similarity;
    }

    /**
     * histogramSimilarity
     *
     * @param  mixed $image1 User Image
     * @param  mixed $image2 Trademark
     * @return void
     */
    public function histogramSimilarity($image1, $image2)
    {
        $image1->histogram_decoded = json_decode($image1->histogram);
        $image2->histogram_decoded = json_decode($image2->histogram);
        $histogram_similarity = array_sum(array_map('min', $image1->histogram_decoded, $image2->histogram_decoded)) /
            array_sum(array_map('max', $image1->histogram_decoded, $image2->histogram_decoded));

        return $histogram_similarity;
    }
}
