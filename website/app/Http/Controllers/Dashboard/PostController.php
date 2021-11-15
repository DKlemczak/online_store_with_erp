<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Posts;
use App\Models\Comments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::paginate(15);
        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function edit($id)
    {
        $posts = Posts::where('id', $id)->first();
        return view('dashboard.posts.edit')->with(['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $posts = new Posts;
        $posts->title = $request->title;
        $posts->description = $request->description;
        $posts->user_id = $user->id;
        $posts->save();

        return redirect()->route('dashboard.posts.index');
    }

    public function update(Request $request, $id)
    {
        $posts = Posts::where('id', $id)->first();
        $posts->title = $request->title;
        $posts->description = $request->description;
        $posts->save();

        return redirect()->route('dashboard.posts.index');
    }

    public function destroy($id)
    {
        $posts = Posts::find($id);
        $comments = Comments::where('posts_id',$id)->get();
        foreach($comments as $comment)
        {
            $comment->delete();
        }
        $posts->delete();
        return redirect()->route('dashboard.posts.index');
    }
}