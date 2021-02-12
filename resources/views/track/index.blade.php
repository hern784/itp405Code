@extends('layouts.main')

@section('title')
    Tracks
@endsection

@section('content')

    <div class="text-end mb-3">
        <a href="{{ route('track.insert')}}">
            New Track
        </a>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Album</th>
                <th>Artist</th>
                <th>Media Type</th>
                <th>Genre</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
                <tr>
                    <td>{{$track->name}}</td>
                    <td>{{$track->album}}</td>
                    <td>{{$track->artist}}</td>
                    <td>{{$track->media}}</td>
                    <td>{{$track->genre}}</td>
                    <td>{{$track->price}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
