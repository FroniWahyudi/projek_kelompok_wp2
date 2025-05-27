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
    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        News::create($validated);
        return redirect()->route('whats_new')->with('success', 'News created successfully.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $news->fill($validated);
        $news->save();
        return redirect()->route('whats_new', $id)->with('success', 'News updated successfully.');
    }
}
