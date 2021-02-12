@extends('layouts.main')

@section('title')
    Deleting Playlist
@endsection

@section('content')
    <form action="{{ route('playlist.deleted', ['id' => $playlist->id, 'name' => $playlist->name ]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="hidden" name="name" value={{$playlist->name}}>
            Are you sure you want to delete {{$playlist->name}}
        </div>
        <a href="{{ route('playlist.index') }}" >
            <button type="button" class="btn btn-danger">
                Cancel
            </button>
        </a>
        <button type="submit" class="btn btn-primary">
            Delete
        </button>
    </form>
@endsection

