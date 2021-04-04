<?php

namespace App\Jobs;

use App\Mail\UserStats;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Track;

use Exception;

class AnnounceUserStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();
        $artists = Artist::count();
        $playlists = Playlist::count();
        $minutes = intval(Track::sum('milliseconds') / 1000 / 60);

        foreach ($users as $user) {
            if ($user->email) {
                Mail::to($user->email)->send(new UserStats($artists, $playlists, $minutes));
            } else {
                throw new Exception("User {$user->id} is missing an email");
            }
        }
    }
}
