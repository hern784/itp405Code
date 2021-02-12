@extends('layouts.main')

@section('title')
    Add a Track
@endsection

@section('content')
    <form action="{{ route('track.store') }}" method="POST">
        @csrf

        {{--- NAME --}}
        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input 
               type="text" 
               name="name" 
               id="name" 
               class="form-control" 
               value="{{ old('name') }}"
            >
            @error('name')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        {{--- ALBUMS --}}
        <div class="mb-3">
            <label for="album" class="form-label">Album</label>
            <select name="album" id="album" class="form-select">
                <option value="">-- Select Album --</option>
                @foreach($albums as $album)
                    <option 
                        value="{{$album->id}}"
                        {{ $album->id === (int) old('album', $album->title) ? "selected" : "" }}
                        >
                    {{$album->title}}
                    </option>
                @endforeach
            </select>
            @error('album')
            <small class="text-danger">{{$message}}</small>
        @enderror
        </div>

        <div class="mb-3">
            <label for="mType" class="form-label">Media Types</label>
            <select name="mType" id="media" class="form-select">
                <option value="">-- Select Media Type --</option>
                @foreach($mTypes as $mType)
                    <option 
                        value="{{$mType->id}}"
                        {{ $mType->id === (int) old('mType', $mType->name) ? "selected" : "" }}
                        >
                    {{$mType->name}}
                    </option>
                @endforeach
            </select>
            @error('mType')
            <small class="text-danger">{{$message}}</small>
        @enderror
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <select name="genre" id="genre" class="form-select">
                <option value="">-- Select Genres --</option>
                @foreach($genres as $genre)
                    <option 
                        value="{{$genre->id}}"
                        {{ (string)$genre->id === old('genre', $genre->id) ? "selected" : "" }}
                        >
                    {{$genre->name}}
                    </option>
                @endforeach
            </select>
            @error('genre')
            <small class="text-danger">{{$message}}</small>
        @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input 
               type="number" 
               name="price" 
               id="price" 
               class="form-control" 
               value="{{ old('price') }}"
            >
            @error('price')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
@endsection

