@extends('layouts.main')

@section('title')
    Playlist {{$playlist->name}}<br>
    Total tracks: {{$playlistItems->count()}}
@endsection

@section('content')

    <a href="{{route('playlist.index')}}" class="d-block mb-3">Back to playlists</a>
    <br>

    @if ($playlistItems->count() === 0)
        No tracks found for {{$playlist->name}}
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Track</th>
                    <th>Album</th>
                    <th>Artist</th>
                    <th>Genre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($playlistItems as $playlistItem)
                    <tr>
                        <td>{{$playlistItem->id}}</td>
                        <td>{{$playlistItem->track}}</td>
                        <td>{{$playlistItem->album}}</td>
                        <td>{{$playlistItem->artist}}</td>
                        <td>{{$playlistItem->genre}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
