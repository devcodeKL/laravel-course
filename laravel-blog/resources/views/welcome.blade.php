@extends('layouts.app')

@section('content')
    {{-- Insert modify welcome.blade.php codes below: --}}
    <div class="text-center">
        <img src="https://cdn.freebiesupply.com/logos/large/2x/laravel-1-logo-png-transparent.png" class="w-50">

        <h2 class="my-4">Featured Posts:</h2>
        @if(count($posts) > 0)
            @foreach($posts as $post)
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title mb-3"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h4>
                    <h6 class="card-text mb-3">Author: {{$post->user->name}}</h6>
                </div>
            </div>
            @endforeach
        @else
            <div>
                <h2>There are no posts to show</h2>
            </div>
        @endif
    </div>
@endsection