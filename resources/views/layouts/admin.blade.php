@extends('layouts.main')

@section('title', 'Admin')

@section('content')
    <form action="{{ route('admin.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="mode">Toggle Maintenance Mode</label>
            <input type="checkbox" id="mode" name="mode" {{$checked}}>
        </div>
        <button type="submit" class="btn btn-primary">
            Update
        </button>
    </form>

@endsection
