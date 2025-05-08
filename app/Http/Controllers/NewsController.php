<?php

namespace App\Http\Controllers;
use App\Models\News;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show($id)
    {
        $item = News::where('id', $id)->first();

        // Example: assume description is long text
        $fullDesc = $item->description;
        $shortDesc = mb_strimwidth($fullDesc, 0, 200); // get first 200 chars
        $isLong = mb_strlen($fullDesc) > 200;

        return view('index.whats_new', compact( 'item', 'shortDesc', 'fullDesc', 'isLong'));
    }
}
