<?php

namespace App\Http\Controllers;

use App\Classes\ImageCompare;
use App\Jobs\UpdateDominantColors;
use App\Models\Image;
use App\Models\Media;
use App\Models\Trademark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = auth()->user()->images()->where('history', false)->get();

        // return $similarityRatio;
        return view('dashboard.pages.image.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $userImages = $user->images()->where('history', false)->get();
        if($userImages->count() >= 10)
        {
            return redirect()->route('image.index', ['language' => app()->getLocale()])->with('error', 'You can upload maximum 10 images.');
        }

        $messages = [
            'title.required' => __('theme/images.validation.title.required'),
            'title.max' => __('theme/images.validation.title.max'),
            'image.required' => __('theme/images.validation.image.required'),
            'image.image' => __('theme/images.validation.image.image'),
            'image.mimes' => __('theme/images.validation.image.mimes'),
            'image.max' => __('theme/images.validation.image.max'),
        ];
        // only .jpg
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg|max:2048',
        ], $messages);

        $image = $request->file('image');
        $title = $request->title;

        // save image to storage/app/public/user_images/{user_id}/
        $path = Storage::disk('public')->putFile('user_images/' . $user->id, $image);
        $image = new Image();
        $image->title = $title;
        $image->path = $path;
        $image->user_id = $user->id;

        $imageCompare = new ImageCompare();

        $dominantColors = $imageCompare->getDominantColors(storage_path('app/public/' . $image->path), 3);
        // get only hex values
        // $dominantColors = array_map(function ($color) {
        //     return '#' . $color['hex'];
        // }, $dominantColors);

        // $hexColors = [];
        // foreach ($dominantColors as $hex => $bcolor) {
        //     // eğer beyaz ve ya siyahsa sayma
        //     if ($bcolor == '#ffffff' || $bcolor == '#000000') {
        //         continue;
        //     }

        //     // RGB değerlerini alalım
        //     $red = hexdec(substr($bcolor, 1, 2));
        //     $green = hexdec(substr($bcolor, 3, 2));
        //     $blue = hexdec(substr($bcolor, 5, 2));

        //     $treshold = 20;
        //     // eğer renkler birbirine çok yakınsa sayma
        //     if ($red >= (255 - $treshold) && $green >= (255 - $treshold) && $blue >= (255 - $treshold)) {
        //         continue;
        //     }

        //     array_push($hexColors, $bcolor);
        // }

        $image->phash = $imageCompare->getPHash(storage_path('app/public/' . $image->path));
        $image->histogram = $imageCompare->getHistogram(storage_path('app/public/' . $image->path));
        $image->dominant_colors = json_encode($dominantColors);
        $image->save();

        return redirect()->route('image.index', ['language' => app()->getLocale()])->with('success', 'Image added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        $trademarks = Trademark::whereNotNull('dominant_colors')->get();
        // empty array
        $compares = [];
        $binary1 = hex2bin($image->phash);
        $imageCompare = new ImageCompare();
        $image->dominantColors = $imageCompare->getDominantColors(storage_path('app/public/' . $image->path), 3);

        foreach ($trademarks as $trademark) {

            // PHash Similarity
            $binary2 = hex2bin($trademark->phash);
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

            // Color Similarity
            $color_similarity = [];
            $trademark->dominantColors = json_decode($trademark->dominant_colors);
            foreach ($image->dominantColors as $key => $color) {
                foreach ($trademark->dominantColors as $key2 => $color2) {
                    // eğer beyaz ve ya siyahsa sayma
                    if ($color2 == '#ffffff' || $color2 == '#000000') {
                        continue;
                    }

                    // RGB değerlerini alalım
                    $red = hexdec(substr($color2, 1, 2));
                    $green = hexdec(substr($color2, 3, 2));
                    $blue = hexdec(substr($color2, 5, 2));

                    $treshold = 20;
                    // eğer renkler birbirine çok yakınsa sayma
                    if ($red >= (255 - $treshold) && $green >= (255 - $treshold) && $blue >= (255 - $treshold)) {
                        continue;
                    }

                    $color_compare = [
                        'color' => '#' . $color['hex'],
                        'color2' => $color2,
                        'similarity' => $imageCompare->calculateHexSimilarity('#' . $color['hex'], $color2),
                    ];

                    array_push($color_similarity, $color_compare);
                }
            }

            // $color_similarity array ını similarity değerine göre sırala
            usort($color_similarity, function ($a, $b) {
                return $b['similarity'] <=> $a['similarity'];
            });

            $trademark->color_similarity = $color_similarity;

            // Histogram Similarity
            $image->histogram_decoded = json_decode($image->histogram);
            $trademark->histogram_decoded = json_decode($trademark->histogram);
            $histogram_similarity = array_sum(array_map('min', $image->histogram_decoded, $trademark->histogram_decoded)) /
                array_sum(array_map('max', $image->histogram_decoded, $trademark->histogram_decoded));

            $ratio = [
                'trademark' => $trademark,
                'phash_distance' => $distance,
                'histogram_distance' => 0,
                'phash_similarity' => $similarityRatio,
                'histogram_similarity' => $histogram_similarity * 100,
                'color_similarity' => $color_similarity,
                'selected_image_phash' => $image->phash,
                'uploaded_image_phash' => $trademark->phash,
            ];

            array_push($compares, $ratio);
        }

        // order by color_similarity desc
        usort($compares, function ($a, $b) {
            if (count($a['color_similarity']) == 0) {
                return 1;
            }
            if (count($b['color_similarity']) == 0) {
                return -1;
            }

            return $b['color_similarity'][0]['similarity'] <=> $a['color_similarity'][0]['similarity'];
        });

        // // order by similarity desc
        // usort($compares, function ($a, $b) {
        //     return $b['histogram_similarity'] <=> $a['histogram_similarity'];
        // });

        // order by phash_similarity asc
        // usort($compares, function ($a, $b) {
        //     return $b['phash_similarity'] <=> $a['phash_similarity'];
        // });

        $compares = array_slice($compares, 0, 200);

        return view('dashboard.pages.image.show', compact('image', 'compares'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, Image $image)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $image->title = $request->title;
        $image->save();

        return redirect()->route('image.index', ['language' => app()->getLocale()])->with('success', 'Görsel başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $lang, Image $image)
    {
        $image->delete();

        return redirect()->route('image.index', ['language' => auth()->user()->language])->with('success', 'Görsel başarıyla silindi.');
    }

    public function test()
    {
        // $ex = new Colors();
        // $colors = $ex->Get_Color('/Users/metehankiran/Downloads/colorextract_1_3/images/test3.jpg', 10, true, true, 20);
        // return $colors;
        // return "here";
        for ($i = 1; $i <= 200; $i++) {
            $job = new UpdateDominantColors();
            dispatch($job);
        }

        return 'here';

        // $bulletin_id = 1699;
        // $trademarks = Trademark::where([
        //     'bulletin_id' => $bulletin_id,
        // ])->where('dominant_colors', null)->take(10)->get();

        // $ic = new ImageCompare();
        // foreach ($trademarks as $trademark) {
        //     $path = $ic->getPath('bulletins/'.replaceLastSlash($trademark->image_path));
        //     $dominantColors = $ic->getDominantColors($path, 3);
        //     // get only hex values
        //     $dominantColors = array_map(function ($color) {
        //         return '#'.$color['hex'];
        //     }, $dominantColors);

        //     $trademark->dominant_colors = json_encode($dominantColors);
        //     $trademark->save();
        // }
    }

    /**
     * search
     *
     * @return void
     */
    public function search()
    {
        $bulletins = Media::where('is_official', 1)->where('is_saved', 1)->latest()->take(5)->get();

        return view('dashboard.pages.image.search', compact('bulletins'));
    }

    /**
     * searchPost
     *
     * @param  mixed  $request
     * @return void
     */
    public function searchPost(Request $request)
    {
        // set memory limit
        ini_set('memory_limit', '512M');
        // only .jpg and .jpeg
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg|max:2048',
        ]);

        $bulletin = Media::find($request->bulletin);

        $image = $request->file('image');
        $title = $image->getClientOriginalName();
        $user_id = auth()->user()->id;

        // save image to storage/app/public/user_images/{user_id}/
        $path = Storage::disk('public')->putFile('user_images/' . $user_id, $image);
        $image = new Image();
        $image->title = $title;
        $image->path = $path;
        $image->user_id = $user_id;
        $image->history = true;
        $imageCompare = new ImageCompare();
        $dominantColors = $imageCompare->getDominantColors(storage_path('app/public/' . $image->path), 3);
        // get only hex values
        $dominantColors = array_map(function ($color) {
            return '#' . $color['hex'];
        }, $dominantColors);

        $hexColors = [];
        foreach ($dominantColors as $hex => $bcolor) {
            // eğer beyaz ve ya siyahsa sayma
            if ($bcolor == '#ffffff' || $bcolor == '#000000') {
                continue;
            }
            // RGB değerlerini alalım
            $red = hexdec(substr($bcolor, 1, 2));
            $green = hexdec(substr($bcolor, 3, 2));
            $blue = hexdec(substr($bcolor, 5, 2));

            $treshold = 20;
            // eğer renkler birbirine çok yakınsa sayma
            if ($red >= (255 - $treshold) && $green >= (255 - $treshold) && $blue >= (255 - $treshold)) {
                continue;
            }

            array_push($hexColors, $bcolor);
        }

        $image->phash = $imageCompare->getPHash(storage_path('app/public/' . $image->path));
        $image->histogram = $imageCompare->getHistogram(storage_path('app/public/' . $image->path));
        $image->dominant_colors = json_encode($hexColors);

        // eğer resim daha önce yüklenmemişse kaydet
        if (!Image::where('phash', $image->phash)->exists()) {
            $image->save();
        }

        $trademarks = Trademark::where('bulletin_id', 1711)->whereNotNull([
            'dominant_colors', 'phash', 'histogram'
        ])->get();


        // empty array
        $compares = [];
        $binary1 = hex2bin($image->phash);
        $imageCompare = new ImageCompare();
        $image->dominantColors = $imageCompare->getDominantColors(storage_path('app/public/' . $image->path), 3);

        foreach ($trademarks as $trademark) {
            // PHash Similarity
            $binary2 = hex2bin($trademark->phash);
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

            // Color Similarity
            $color_similarity = [];
            $trademark->dominantColors = json_decode($trademark->dominant_colors);
            foreach ($image->dominantColors as $key => $color) {
                foreach ($trademark->dominantColors as $key2 => $color2) {
                    // eğer beyaz ve ya siyahsa sayma
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
                        'color' => '#' . $color['hex'],
                        'color2' => $color2Hex,
                        'similarity' => $imageCompare->calculateHexSimilarity('#' . $color['hex'], $color2Hex),
                    ];

                    array_push($color_similarity, $color_compare);
                }
            }
            // $color_similarity array ını similarity değerine göre sırala
            usort($color_similarity, function ($a, $b) {
                return $b['similarity'] <=> $a['similarity'];
            });

            $trademark->color_similarity = $color_similarity;

            // Histogram Similarity
            $image->histogram_decoded = json_decode($image->histogram);
            $trademark->histogram_decoded = json_decode($trademark->histogram);
            $histogram_similarity = array_sum(array_map('min', $image->histogram_decoded, $trademark->histogram_decoded)) /
                array_sum(array_map('max', $image->histogram_decoded, $trademark->histogram_decoded));

            $ratio = [
                'trademark' => $trademark,
                'phash_distance' => $distance,
                'histogram_distance' => 0,
                'phash_similarity' => $similarityRatio,
                'histogram_similarity' => $histogram_similarity * 100,
                'color_similarity' => $color_similarity,
                'selected_image_phash' => $image->phash,
                'uploaded_image_phash' => $trademark->phash,
            ];
            array_push($compares, $ratio);
        }

        // order by color_similarity desc
        usort($compares, function ($a, $b) {
            if (count($a['color_similarity']) == 0) {
                return 1;
            }
            if (count($b['color_similarity']) == 0) {
                return -1;
            }

            return $b['color_similarity'][0]['similarity'] <=> $a['color_similarity'][0]['similarity'];
        });

        $similarity['color_similarity'] = array_slice($compares, 0, 6);

        // order by similarity desc
        usort($compares, function ($a, $b) {
            return $b['histogram_similarity'] <=> $a['histogram_similarity'];
        });

        $similarity['histogram_similarity'] = array_slice($compares, 0, 6);

        // order by phash_similarity asc
        usort($compares, function ($a, $b) {
            return $b['phash_similarity'] <=> $a['phash_similarity'];
        });

        $similarity['phash_similarity'] = array_slice($compares, 0, 6);
        $compares = array_slice($compares, 0, 200);
        $bulletins = Media::where('is_official', 1)->where('is_saved', 1)->latest()->take(5)->get();

        // remaining_image_search desc
        auth()->user()->remaining_image_search = auth()->user()->remaining_image_search - 1;
        auth()->user()->save();

        return view('dashboard.pages.image.search', compact('image', 'similarity', 'bulletins'));
    }

    public function history($page, $historedImage = null)
    {
        $image = Image::find($historedImage);
        $trademarks = Trademark::where('bulletin_id', 1711)->whereNotNull([
            'dominant_colors', 'phash', 'histogram'
        ])->get();
        // empty array
        $compares = [];
        $binary1 = hex2bin($image->phash);
        $imageCompare = new ImageCompare();
        $image->dominantColors = $imageCompare->getDominantColors(storage_path('app/public/' . $image->path), 3);

        foreach ($trademarks as $trademark) {

            // PHash Similarity
            $binary2 = hex2bin($trademark->phash);
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

            // Color Similarity
            $color_similarity = [];
            $trademark->dominantColors = json_decode($trademark->dominant_colors);
            foreach ($image->dominantColors as $key => $color) {
                foreach ($trademark->dominantColors as $key2 => $color2) {
                    // eğer beyaz ve ya siyahsa sayma
                    if ($color2 == '#ffffff' || $color2 == '#000000') {
                        continue;
                    }

                    // RGB değerlerini alalım
                    $red = hexdec(substr($color2, 1, 2));
                    $green = hexdec(substr($color2, 3, 2));
                    $blue = hexdec(substr($color2, 5, 2));

                    $treshold = 20;
                    // eğer renkler birbirine çok yakınsa sayma
                    if ($red >= (255 - $treshold) && $green >= (255 - $treshold) && $blue >= (255 - $treshold)) {
                        continue;
                    }

                    $color_compare = [
                        'color' => '#' . $color['hex'],
                        'color2' => $color2,
                        'similarity' => $imageCompare->calculateHexSimilarity('#' . $color['hex'], $color2),
                    ];

                    array_push($color_similarity, $color_compare);
                }
            }

            // $color_similarity array ını similarity değerine göre sırala
            usort($color_similarity, function ($a, $b) {
                return $b['similarity'] <=> $a['similarity'];
            });

            $trademark->color_similarity = $color_similarity;

            // Histogram Similarity
            $image->histogram_decoded = json_decode($image->histogram);
            $trademark->histogram_decoded = json_decode($trademark->histogram);
            $histogram_similarity = array_sum(array_map('min', $image->histogram_decoded, $trademark->histogram_decoded)) /
                array_sum(array_map('max', $image->histogram_decoded, $trademark->histogram_decoded));

            $ratio = [
                'trademark' => $trademark,
                'phash_distance' => $distance,
                'histogram_distance' => 0,
                'phash_similarity' => $similarityRatio,
                'histogram_similarity' => $histogram_similarity * 100,
                'color_similarity' => $color_similarity,
                'selected_image_phash' => $image->phash,
                'uploaded_image_phash' => $trademark->phash,
            ];

            array_push($compares, $ratio);
        }

        // order by similarity desc
        usort($compares, function ($a, $b) {
            return $b['histogram_similarity'] <=> $a['histogram_similarity'];
        });
        $similarity['histogram_similarity'] = array_slice($compares, 0, 6);

        // order by phash_similarity asc
        usort($compares, function ($a, $b) {
            return $b['phash_similarity'] <=> $a['phash_similarity'];
        });
        $similarity['phash_similarity'] = array_slice($compares, 0, 6);


        // order by color_similarity desc
        usort($compares, function ($a, $b) {
            if (count($a['color_similarity']) == 0) {
                return 1;
            }
            if (count($b['color_similarity']) == 0) {
                return -1;
            }

            return $b['color_similarity'][0]['similarity'] <=> $a['color_similarity'][0]['similarity'];
        });
        $similarity['color_similarity'] = array_slice($compares, 0, 6);

        return view('dashboard.pages.image.search', compact('image', 'similarity'));
    }

    public function fill()
    {
        $bulletin = Media::where('bulletin_no', 434)->first();
        $trademarks = Trademark::where([
            'bulletin_id' => $bulletin->id,
            'histogram' => null,
            'phash' => null,
            'dominant_colors' => null,
        ])->get();
        $imageCompare = new ImageCompare();
        if (count($trademarks) > 0) {
            foreach ($trademarks->take(200) as $trademark) {
                $path = storage_path('app/public/bulletin/' . replaceLastSlash($trademark->image_path));
                $dominantColors = $imageCompare->getDominantColors($path, 3);
                $histogram = $imageCompare->getHistogram($path);
                $phash = $imageCompare->getPHash($path);
                $trademark->dominant_colors = json_encode($dominantColors);
                $trademark->histogram = $histogram;
                $trademark->phash = $phash;
                $trademark->save();
            }
            return $trademarks->count();
        }

        return "filled";
    }
}
