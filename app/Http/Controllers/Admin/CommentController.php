<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Panel\PanelController;
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
class CommentController extends Controller
{
    public function index(){
        $comments = Comment::join('users','users.id','comments.user_id')->join('posts','posts.id','comments.post_id')->select('users.name','posts.title','comments.id','comments.body','comments.created_at')->get();
         return view('admin.comments',['comments' => $comments]); 
    }
    
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back();
    }
}