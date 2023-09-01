<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Comment;
use App\Utils\ResponseCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    //

    public function getData(){
        $data = Blog::with('user', 'comments', 'comments.user')->get();

        return ResponseCode::successGet($data, 'Success get data');
    }

    public function storeData($data){

        Blog::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $data['author'],
            'status' => $data['status'],
            'user_id' => Auth::user()->id,
            'published_at' => $data['status'] == 'Published' ? Carbon::now() : null,
        ]);

        return ResponseCode::successPost(null, 'Success store data');
    }

    public function updateData($data, $blog_id){
        $blog = Blog::find($blog_id);

        if(!$blog){
            return ResponseCode::errorPost(null, 'Blog not found');
        }

        $blog->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $data['author'],
            'status' => $data['status'],
            'user_id' => Auth::user()->id,
            'published_at' => $data['status'] == 'Published' ? Carbon::now() : null,
        ]);

        return ResponseCode::successPost(null, 'Success update data');
    }

    public function deleteData($blog_id){
        $blog = Blog::find($blog_id);

        if(!$blog){
            return ResponseCode::errorPost(null, 'Blog not found');
        }

        $blog->delete();

        return ResponseCode::successPost(null, 'Success delete data');
    }

    public function filterData($data){


        $blog = Blog::where('status', $data['status'])
            ->where('author', 'like', '%'.$data['author'].'%')
            ->whereDate('created_at', $data['date'] ?? null)
            ->get();

        return ResponseCode::successGet($blog, 'Success filter data');
    }


    public function postComment($data){
        // dd($data);

        Comment::create([
            'blog_id' => $data['blog_id'],
            'comment' => $data['comment'],
            'user_id' => Auth::user()->id,
        ]);

        return ResponseCode::successPost(null, 'Success Added comment');
    }

    public function updateComment($data){
        $comment = Comment::where('id', $data['comment_id'])->where('user_id', Auth::user()->id)->first();

        if(!$comment){
            return ResponseCode::errorPost(null, 'Comment not found');
        }

        $comment->update([
            'comment' => $data['comment'],
        ]);

        return ResponseCode::successPost(null, 'Success update comment');
    }

    public function deleteComment($comment_id){
        $comment = Comment::where('id', $comment_id)->where('user_id', Auth::user()->id)->first();

        if(!$comment){
            return ResponseCode::errorPost(null, 'Comment not found');
        }

        $comment->delete();

        return ResponseCode::successPost(null, 'Success delete comment');
    }

}