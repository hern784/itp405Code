@extends('layouts.email')

@section('content')
<h1>These are the stats</h1>
<p>Total artists: {{$artists}}</p>
<p>Total playlists: {{$playlists}}</p>
<p>Total minutes: {{$minutes}}</p>
@endsection
