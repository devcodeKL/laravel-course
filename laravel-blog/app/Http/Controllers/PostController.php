<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Import the Post Model
use App\Models\Post;

// access the authenticaed user via the Auth facade
// In Laravel, Auth facade provides a convenient way to interact with the authentication system and access information about the currently authenticated user.
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // action to return a view containing a form for blog post creation
    public function create()
    {
        // view() method is used to render a specific view in the browser
        return view('posts.create');
    }

    // action to receive form data and subsequently store said data in the posts table
    // this action needs a parameter of class Request
    public function store(Request $request)
    {
        // Check if there is an authenticated user
        if(Auth::user()){
            // instantiate a new Post object from the Post model
            $post = new Post;

            // define the properties of the $post object using the received form data
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            // get the id of the authenticated user and set it as the foreign key user_id of the new post
            $post->user_id = (Auth::user()->id);
            // save this post object in the database
            $post->save();

            return redirect('/posts');
        }else{
            return redirect('/login');
        }
    }

    // action that will return a "view" showing all blog posts
    public function index()
    {
        // This line will retrieve all records from the 'posts' table in the database.
        $posts = Post::all();
        // This line returns a view named 'posts.index' and passes data to that view.
        // The with() method is used to pass data to the view, where the first argument is the name of the variable that will be avilable in the view, and the second argument is the data itself.
        return view('posts.index')->with('posts', $posts);
    }

    // action that will return a view showing three random blog post
    public function welcome(){
        $posts = Post::inRandomOrder()
        ->limit(3)
        ->get();

        return view('welcome')->with('posts', $posts);
    }

    // action for showing only the posts authored by authenticated user
    public function myPosts()
    {
        // Checks if there is an authenticated user.
        if(Auth::user()){
            // Retrieves the post authored by the authenticated user.
            $posts = Auth::user()->posts;
            // Returns the 'posts.index' view and passed the retrieved posts to the view using 'with' method.
            return view('posts.index')->with('posts', $posts);
        }else{
            // If there is no authenticated user, redirect the user to the '/login' route.
            return redirect('/login');
        }
    }

    // action that will return a view showing a specific post using the URL parameter $id to query for the database entry to be shown
    public function show($id)
    {
        // Retrieves the post with the given "$id" from the find() method.
        $post = Post::find($id);
        // returns the 'posts.show' view and passed the retrieved post to the view using the 'with()' method
        return view('posts.show')->with('post', $post);
    }

    // action that will return an edit form for a specific Post when a GET request is received at the /posts/{id}/edit endpoint.
    public function edit($id){
        // $post = Post::find($id);
        $post = Post::findOrFail($id); //this will return 404 page if no records found. 
        // return view('posts.edit')->with('post', $post);
        
        // Stretch Goals
        if(Auth::user()){
            if(Auth::user()->id == $post->user_id){
                return view('posts.edit')->with('post', $post);
            }
            return redirect('/posts');
        }
        else{
            return redirect('/login');
        }
    }
}
