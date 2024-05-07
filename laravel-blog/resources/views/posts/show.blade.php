@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-body">
			<h2 class="card-title">{{$post->title}}</h2>
			<p class="card-subtitle text-muted">Author: {{$post->user->name}}</p>
			<p class="card-subtitle text-muted mb-3">Created at: {{$post->created_at}}</p>
			<p class="card-text">{{$post->content}}</p>
			<div class="mt-3">
				<a href="/posts" class="card-link">View all posts</a>
			</div>
		</div>
	</div>
@endsection