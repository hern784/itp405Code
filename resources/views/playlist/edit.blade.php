@extends('layouts.main')

@section('title')
    Editing Playlist
@endsection

@section('content')
    <form action="{{ route('playlist.update', ['id' => $playlist->id ]) }}" method="POST">
        @csrf
        <input 
            type="hidden" 
            name="oldName" 
            id="oldName" 
            value="{{$playlist->name}}">
        <div class="mb-3">
            <label for="playlist" class="form-label">Playlist</label>
            <input 
               type="text" 
               name="name" 
               id="name" 
               class="form-control" 
               value="{{ old('name', $playlist->name) }}">
            @error('name')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
@endsection

