<?php

namespace App\Imports;

use App\Models\Keyword;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class KeywordsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($id)
    {
        $this->id =$id;
    }
    public function model(array $row)
    {
        $id = $this->id;

        $classes = $row[1];
        $ArrayClasses = explode(',',$classes);

        $slug = Str::slug($row[0]);
        $keywords = Keyword::where('user_id', $id);

        if ($keywords->where('keyword', $row[0])->count() == 0) {
            if($row[0] != null) {
                return Keyword::create([
                    'user_id' => $id,
                    'keyword' => $row[0],
                    'slug' => $slug,
                    'classes' => $ArrayClasses,
                ]);
            }
        }
    }
}
