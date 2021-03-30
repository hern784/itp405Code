<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PlaylistController extends Controller
{
    //
    public function index()
    {
        $playlists = DB::table('playlists')
            ->orderBy('id')
            ->get([
                'id',
                'name'
            ]);

        return view('playlist.index', [
            'playlists' => $playlists
        ]);
    }

    public function show($id)
    {

        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();


        $playlistItems = DB::table('playlist_track')
            ->where('playlist_track.playlist_id', '=', $id)
            ->join('tracks', 'playlist_track.track_id', '=', 'tracks.id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->get([
                'tracks.id',
                'tracks.name AS track',
                'albums.title AS album',
                'tracks.composer AS artist',
                'genres.name AS genre',
            ]);

        return view('playlist.show', [
            'playlist' => $playlist,
            'playlistItems' => $playlistItems,
        ]);
    }

    public function edit($id)
    {
        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();


        return view('playlist.edit', [
            'playlist' => $playlist,
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:30|unique:playlists,name'
        ]);
        $oldName = $request->input('oldName');

        DB::table('playlists')
            ->where('id', '=', $id)
            ->update([
                'name' => $request->input('name'),
            ]);

        return redirect()
            ->route('playlist.index')
            ->with('success', "{$request->input('oldName')} was successfully renamed to {$request->input('name')}");
    }

    public function delete($id)
    {
        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();


        return view('playlist.delete', [
            'playlist' => $playlist,
        ]);
    }

    public function deleted($id, Request $request)
    {
        DB::table('playlists')
            ->where('id', '=', $id)
            ->delete();

        DB::table('playlist_track')
            ->where('playlist_id', '=', $id)
            ->delete();

        return redirect()
            ->route('playlist.index')
            ->with('success', "The {$request->input('name')} playlist was successfully deleted");
    }
}
