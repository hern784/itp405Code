<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;

class Ealbum extends Model
{
    use HasFactory;

    protected $table = 'albums';

    public function artist()
    {
        // albums.artist_id is the foregin key column
        return $this->belongsTo(Artist::class);
    }
}
