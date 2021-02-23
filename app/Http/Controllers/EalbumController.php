<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ealbum;
use App\Models\Artist;

class EalbumController extends Controller
{

    public function index()
    {
        return view('ealbum.index', [
            'albums' => Ealbum::with(['artist'])
                ->orderBy('artist_id', 'asc')
                ->orderBy('title', 'asc')
                ->get()
        ]);
    }

    public function create()
    {
        return view('ealbum.create', [
            'artists' => Artist::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = new Ealbum();
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();

        return redirect()
            ->route('ealbum.index')
            ->with('success', "successfully created {$request->input('title')}");
    }

    public function edit($id)
    {
        return view('ealbum.edit', [
            'artists' => Artist::orderBy('name')->get(),
            'album' => Ealbum::find($id)
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = Ealbum::find($id);
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();

        return redirect()
            ->route('ealbum.edit', ['id' => $id])
            ->with('success', "Successfully updated {$request->input('title')}");
    }
}
