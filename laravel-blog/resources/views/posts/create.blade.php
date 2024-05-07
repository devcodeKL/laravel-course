<!-- extends: By using this directive, you can include this common structure in your master layout/view -->
@extends('layouts.app')

<!-- this directive in laravel blade is used to define a named section in your Blade view. This named section serves as a placeholder within your view file where you can insert content -->
<!-- The 'content' section name is typically defined in the master layout ('layouts.app') -->
<!-- This can be displayed using "yield", which is used to define a placeholder in a layout file where content from child views can be injected -->
@section('content')
	<form method="POST" action="/posts">
		<!-- This Blade directive generates a hidden CSRF token field within the form -->
		<!-- CSRF - Cross-Site Request Forgery -->
		<!-- It is a form of attack where malicious users may send malicious requests while pretending to be the authorized user. -->
		@csrf
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="form-group">
        <label for="content">Content:</label>
        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
      </div>
      <div class="mt-2">
        <button type="submit" class="btn btn-primary">Create Post</button>
      </div>
    </form>
@endsection