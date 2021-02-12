@extends('layouts.main')

@section('title', 'Playlists')

@section('content')
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Playlist</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($playlists as $playlist)
        <tr>
            <td>
                {{$playlist->id}}
            </td>
            <td>
                <a href="{{route('playlist.show', ['id' => $playlist->id])}}">
                    {{$playlist->name}}
                </a>
            </td>
            <td>
                <a href="{{route('playlist.edit', ['id' => $playlist->id])}}">
                    Rename
                </a>
            </td>
            <td>
                <a href="{{route('playlist.delete', ['id' => $playlist->id])}}">
                    Delete
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
