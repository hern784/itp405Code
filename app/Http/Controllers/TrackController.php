<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    //
    public function index()
    {
        $tracks = DB::table('tracks')
            ->join('albums', 'albums.id', '=', 'tracks.album_id')
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->join('media_types', 'media_types.id', '=', 'tracks.media_type_id')
            ->join('genres', 'genres.id', '=', 'tracks.genre_id')
            ->orderBy('artist')
            ->orderBy('title')
            ->get([
                'tracks.name',
                'albums.title AS album',
                'artists.name AS artist',
                'media_types.name AS media',
                'genres.name AS genre',
                'tracks.unit_price AS price',
            ]);

        return view('track.index', [
            'tracks' => $tracks,
        ]);
    }

    public function insert()
    {
        $albums = DB::table('albums')
            ->get();

        $mTypes = DB::table('media_types')
            ->get();

        $genres = DB::table('genres')
            ->get();

        return view('track.insert', [
            'albums' => $albums,
            'mTypes' => $mTypes,
            'genres' => $genres,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'album' => 'required|exists:albums,id',
            'mType' => 'required|exists:media_types,id',
            'genre' => 'required|exists:genres,id',
            'price' => 'required',
        ]);

        DB::table('tracks')
            ->insert([
                'name' => $request->input('name'),
                'album_id' => $request->input('album'),
                'media_type_id' => $request->input('mType'),
                'genre_id' => $request->input('genre'),
                'unit_price' => $request->input('price'),
            ]);

        return redirect()
            ->route('track.index')
            ->with('success', "The track {$request->input('name')} was successfully created");
    }
}
