<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index()
    {

        $albums = Album::select('albums.*')
            ->with((['artist', 'user']))
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->join('users', 'users.id', '=', 'albums.user_id')
            ->orderBy('artists.name', 'asc')
            ->orderBy('title', 'asc')
            ->get();

        return view('album.index', [
            'albums' => $albums,
            'can_create' => Auth::check()
        ]);
    }

    public function create()
    {
        return view('album.create', [
            'artists' => Artist::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = new Album();
        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->user_id = Auth::user()->id;
        $album->save();

        return redirect()
            ->route('album.index')
            ->with('success', "successfully created {$request->input('title')}");
    }

    public function edit($id)
    {
        $artists = DB::table('artists')
            ->orderBy('name')
            ->get();

        $album = Album::find($id);

        $this->authorize('edit-album', $album);

        return view('album.edit', [
            'artists' => $artists,
            'album' => $album,
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = Album::find($id);

        $this->authorize('edit-album', $album);

        $album->title = $request->input('title');
        $album->artist_id = $request->input('artist');
        $album->save();

        return redirect()
            ->route('album.edit', ['id' => $id])
            ->with('success', "Successfully updated {$request->input('title')}");
    }
}
