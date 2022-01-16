<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\TagResource;
use App\Tag;

class TagController extends Controller
{
    public function getTag(Tag $tag){
        return new TagResource($tag);
    }

    public function getFgColor(String $color){
        $isColorDarkAdv = \isColorDarkAdv($color);
        return ($isColorDarkAdv) ? '#ffffff':'#000000';  
    }
}
