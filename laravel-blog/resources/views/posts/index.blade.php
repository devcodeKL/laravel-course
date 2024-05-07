@extends('layouts.app')

@section('content')
	@if(count($posts) > 0)
		@foreach($posts as $post)
			<div class="card text-center">
				<div class="card-body">
					<!-- in Laravel's Blade template engine double curly braces is a shorthand method in echoing/displaying variables -->
					<h4 class="card-title mb-3"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h4>
					<h6 class="card-text mb-3">Author: {{$post->user->name}}</h6>
					<p class="card-subtitle mb-3 text-muted">Created at: {{$post->created_at}}</p>
				</div>
				<!-- Check if the current user is aunthenticated -->
				@if(Auth::user())
					<!-- if the authenticated user is the author of this blog post -->
					@if(Auth::user()->id == $post->user_id)
						<div class="card-footer">
							<form method="POST" action="/posts/{{$post->id}}">
								@method('DELETE')
								@csrf
								<a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit Post</a>
								<button type="submit" class="btn btn-danger">Delete Post</button>
							</form>
						</div>
					@endif
				@endif
			</div>
		@endforeach
	@else
		<div>
			<h2>There are no posts to show</h2>
			<a href="/posts/create" class="btn btn-info">Create post</a>
		</div>
	@endif
@endsection