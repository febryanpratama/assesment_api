<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use App\Utils\ResponseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    //

    protected $blogService;
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    public function index(){
        $response = $this->blogService->getData();

        return $response;
    }

    public function store(Request $request){

        // dd(Auth::user());
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required|in:Draft,Published',
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first(), "Validation Error");
        }
        $response = $this->blogService->storeData($request->all());

        return $response;
    }
    public function update(Request $request, $blog_id){

        // dd(Auth::user());
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required|in:Draft,Published',
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first(), "Validation Error");
        }
        $response = $this->blogService->updateData($request->all(), $blog_id);

        return $response;
    }

    public function delete($blog_id){

        $response = $this->blogService->deleteData($blog_id);

        return $response;
    }

    public function filter(Request $request){

        $validator = Validator::make($request->all(),[
            'status' => 'required|in:Draft,Published',
            'author' => 'required',
            'date' => 'required|date_format:Y-m-d',
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first(), "Validation Error");
        }

        $response = $this->blogService->filterData($request->all());

        return $response;
    }


    public function storeComment(Request $request){

        $validator = Validator::make($request->all(),[
            'blog_id' => 'required|exists:blogs,id',
            'comment' => 'required',
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first(), "Validation Error");
        }

        $response = $this->blogService->postComment($request->all());

        return $response;
    }

    public function updateComment(Request $request){

        $validator = Validator::make($request->all(),[
            'comment_id' => 'required|exists:comments,id',
            'comment' => 'required',
        ]);

        if($validator->fails()){
            return ResponseCode::errorPost($validator->errors()->first(), "Validation Error");
        }

        $response = $this->blogService->updateComment($request->all());

        return $response;
    }

    public function deleteComment($comment_id){
            
            $response = $this->blogService->deleteComment($comment_id);
    
            return $response;
    }
}
