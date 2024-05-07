<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Import the Post Model
use App\Models\Post;
// Import the PostLike Model
use App\Models\PostLike;
// Import the PostComment Model
use App\Models\PostComment;

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
        // $posts = Post::all();
        $posts = Post::where('isActive', true)->get();
        // This line returns a view named 'posts.index' and passes data to that view.
        // The with() method is used to pass data to the view, where the first argument is the name of the variable that will be avilable in the view, and the second argument is the data itself.
        return view('posts.index')->with('posts', $posts);
    }

    // action that will return a view showing three random blog post
    public function welcome(){
        $posts = Post::inRandomOrder()
        ->where('isActive', true)
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
        // Retrieve all comments associated with a specific post id
        $comments = PostComment::all()->where('post_id', $post->id);
        // returns the 'posts.show' view, providing it with two pieces of data: the $post variable representing a specific post, and the $comments variable representing a collection of comments associated with that post using the 'with()' method
        return view('posts.show')->with('post', $post)->with('comments', $comments);
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

    // action that will edit the specific post
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        // if authenticated User's ID is the same as the post's user_id
        if(Auth::user()->id == $post->user_id){
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->save();
        }
        return redirect('/posts');
    }

    // action to delete the specific post
    // public function destroy($id)
    // {
    //     $post = Post::find($id);

    //     // if authenticated user's ID is the same as the post's user_id
    //     if(Auth::user()->id == $post->user_id){
    //         $post->delete();
    //     }
    //     return redirect('/posts');
    // }

    // Activity Solution
    public function archive($id)
    {

        $post = Post::find($id);

        if(Auth::user()->id == $post->user_id){
            $post->isActive = false;
            $post->save();
        }
        return redirect('/posts');
    }

    // action on liking a specific post
    public function like($id)
    {
        // retrieves the post with the given 'id' from the database
        $post = Post::find($id);
        // retrives the ID of the authenticated user
        $user_id = Auth::user()->id;
        // if authenticated user is not the post author
        if($post->user_id != $user_id){
            // checks if the authenticated user has already liked the post before by querying the likes relationship on the post object
            if($post->likes->contains("user_id", $user_id)){
                // delete the like made by this user to unlike this post
                // If the user has already liked the post, it deletes the like record, effectively "unliking" the post
                PostLike::where('post_id', $post->id)->where('user_id', $user_id)->delete();
            }else{
                // create a new like record to like a specific post
                // instantiate a new PostLike object from the PostLike model.
                $postLike = new PostLike;
                // define the properties of the $postLike object
                $postLike->post_id = $post->id;
                $postLike->user_id = $user_id;

                // save this postLike object in the database
                $postLike->save();
            }
            return redirect("/posts/$id");
        }
    }

    // action commenting on a specific post
    public function comment(Request $request, $id)
    {
        $post = Post::find($id);
        $user_id = Auth::user()->id;

            $postComment = new PostComment;

            $postComment->content = $request->input('content');
            $postComment->post_id = $post->id;
            $postComment->user_id = $user_id;

            $postComment->save();
            
            return redirect("/posts/$id");
        
    }

    // action deleting a comment associated with a specific post if the authenticated user is the owner of that comment
    public function deleteComment($id, $commentId)
    {
        $comment = PostComment::find($commentId);

        if(Auth::user()->id == $comment->user_id){
            $comment->delete();
        }

        return redirect("/posts/$id");
    }
}
