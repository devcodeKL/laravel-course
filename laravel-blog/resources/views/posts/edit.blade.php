@extends('layouts.app')

@section('content')
    <form method="POST" action="/posts/{{$post->id}}">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="title">Title: </label>
            <input type="text" name="title" id="title" class="form-control" value="{{$post->title}}" />
        </div>
        <div class="form-group">
            <label for="content">Content: </label>
            <textarea class="form-control" id="content" name="content" rows="3">{{$post->content}}</textarea>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">Update Post</button>
        </div>
    </form>
@endsection