<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Comments;
use Carbon\Carbon;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::paginate(15);
        return view('posts.index', ['posts' => $posts]);
    }

    public function details($id)
    {
        $post = Posts::where('id', $id)->first();

        return view('posts.details',['post' => $post]);
    }

    public function storecomment(Request $request, $id)
    {
        $user = Auth::user();
        $comment = new Comments;
        $comment->comment = $request->comment;
        $comment->posts_id = $id;
        $comment->created_at = date('Y-m-d');
        $comment->user_id = $user->id;
        $comment->save();

        return redirect()->route('posts.details', ['id' => $id]);
    }

    public function destroycomment($comment_id)
    {
        $comment = Comments::find($comment_id);
        $id = $comment->posts_id;
        $comment->delete();

        return redirect()->route('posts.details', ['id' => $id]);
    }
}
