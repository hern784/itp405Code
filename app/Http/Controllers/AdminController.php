<?php

namespace App\Http\Controllers;

use App\Jobs\AnnounceUserStats;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Track;

class AdminController extends Controller
{
    public function maintenance()
    {
        $checked = Configuration::select('value')->first()->value ? "checked" : "";

        return view('layouts.admin', [
            'checked' => $checked
        ]);
    }

    public function update(Request $request)
    {
        $mode = $request->input('mode') == 'on' ? true : false;
        $checked = $mode ? "checked" : "";
        DB::table('configurations')
            ->where('name', '=', 'maintenance-mode')
            ->update([
                'value' => $mode
            ]);
        return view('layouts.admin', [
            'checked' => $checked
        ]);
    }

    public function email_user_stats()
    {
        $artists = Artist::count();
        $playlists = Playlist::count();
        $minutes = intval(Track::sum('milliseconds') / 1000 / 60);
        dispatch(new AnnounceUserStats($artists, $playlists, $minutes));
        return view('email.user-stats-sent', [
            'artists' => $artists,
            'playlists' => $playlists,
            'minutes' => $minutes
        ]);
    }
}
