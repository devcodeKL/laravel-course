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
}
