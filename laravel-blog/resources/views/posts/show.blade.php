@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-body">
			<h2 class="card-title">{{$post->title}}</h2>
			<p class="card-subtitle text-muted">Author: {{$post->user->name}}</p>
			<p class="card-subtitle text-muted mb-3">Created at: {{$post->created_at}}</p>
			<p class="card-text">{{$post->content}}</p>
            
            <!-- Number of Likes and Comments -->
			@if((count($post->likes) > 0) || (count($post->comments) > 0))
				<div class="my-2 text-muted">
					@if(count($post->likes) > 0)
					<span class="mt-2">Likes: {{count($post->likes)}}</span>
					@endif
					@if(count($post->likes) > 0 && count($post->comments) > 0)
					<span class="mt-2"> | </span>
					@endif
					@if(count($post->comments) > 0)
					<span class="mt-2">Comments: {{count($post->comments)}}</span>
					@endif
				</div>
			@endif

			<!-- Like / Unlike -->
            @if(Auth::id() != $post->user_id)
				<form class="d-inline" method="POST" action="/posts/{{$post->id}}/like">
					@method('PUT')
					@csrf
					@if($post->likes->contains("user_id", Auth::id()))
					<button type="submit" class="btn btn-danger">Unlike</button>
					@else
					<button type="submit" class="btn btn-success">Like</button>
					@endif
				</form>
			@endif

            <!-- Add Comment -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                Comment
            </button>

            <form method="POST" action="/posts/{{$post->id}}/comment">
                @csrf
                <div class="modal" id="myModal">
                    <div class="mx-auto modal-dialog">
                        <div class="modal-content">
                
                            <!-- Modal header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Leave a comment</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                    
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="content">Comment:</label>
                                    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                                </div>
                            </div>
                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		                        <button type="submit" class="btn btn-primary">Comment</button>
                            </div>
                
                        </div>
                    </div>
                </div>
            </form>

			<div class="mt-3">
				<a href="/posts" class="card-link">View all posts</a>
			</div>
		</div>
	</div>

    <!-- Show Comments -->
    @if(count($post->comments) > 0)
        <h4 class="mt-5">Comments:</h4> 
        @foreach($post->comments as $comment)
            <div class="card mt-2">
                <div class="card-body">
                    <h4 class="card-title text-center">{{$comment->content}}</h4>
                    <div class="card-text text-end">
                        <h6 class="card-subtitle mb-3">Posted by: {{$comment->user->name}}</h6>
                        <p class="card-subtitle text-muted mb-3">posted on: {{$comment->created_at}}</p>

                        <!-- Delete Comment Button (if user owns the comment) -->
                        @if(Auth::id() == $comment->user_id)
                            <form method="POST" action="/posts/{{$post->id}}/{{$comment->id}}/delete">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="text-danger btn btn-link btn-sm">Delete Comment</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="mt-5">No comments yet.</p>
    @endif

@endsection