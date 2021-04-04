<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Track;

class UserStats extends Mailable
{
    use Queueable, SerializesModels;
    public  $artists;
    public  $playlists;
    public  $minutes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($artists, $playlists, $minutes)
    {
        $this->artists = $artists;
        $this->playlists = $playlists;
        $this->minutes = $minutes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("check out the stats.")
            ->view('email.user-stats');
    }
}
