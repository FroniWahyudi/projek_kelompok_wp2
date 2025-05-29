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
        $edit = false; // Flag to indicate if this is an edit or create operation
        return view('news.edit', compact('edit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        ]);

        $validated['date'] = now(); // Set current date
        $validated['link'] = ''; // Initialize link, can be set later if needed

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        News::create($validated);
        return redirect()->route('dashboard')->with('success', 'News created successfully.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $edit = true; // Flag to indicate this is an edit operation
        return view('news.edit', compact('news', 'edit'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
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

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('dashboard')->with('success', 'News deleted successfully.');
    }
}
