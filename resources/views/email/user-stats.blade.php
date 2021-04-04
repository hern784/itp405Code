@extends('layouts.email')

@section('content')
    <div class="card">

        <h1 class='card-title'>These are the stats</h1>
        <p class='card-text'>Total artists: {{$artists}}</p>
        <p class='card-text'>Total playlists: {{$playlists}}</p>
        <p class='card-text'>Total minutes: {{$minutes}}</p>
    </div>
@endsection
