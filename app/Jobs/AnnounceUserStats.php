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
    public  $artists;
    public  $playlists;
    public  $minutes;

    public function __construct($artists, $playlists, $minutes)
    {
        $this->artists = $artists;
        $this->playlists = $playlists;
        $this->minutes = $minutes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->email) {
                Mail::to($user->email)->send(new UserStats($this->artists, $this->playlists, $this->minutes));
            } else {
                throw new Exception("User {$user->id} is missing an email");
            }
        }
    }
}
