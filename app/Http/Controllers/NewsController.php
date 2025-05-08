<?php

namespace App\Http\Controllers;
use App\Models\News;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show($id)
    {
        // Example: Fetch the news item from the database
        $newsItem = News::findOrFail($id);

        // Return a view and pass the news item to it
        return view('news.show', ['item' => $newsItem]);
    }
}
