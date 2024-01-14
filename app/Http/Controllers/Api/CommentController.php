<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // store comment 
    public function store(Request $request) {

        // validate incoming request
        $validator = Validator::make($request->all(), [
            'post_id'         => ['required', 'exists:posts,id', 'integer'],
            'commenter_name'  => ['required', 'string', 'max:255'],
            'content'         => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $response_data['errors'] = $validator->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }

        DB::beginTransaction();
        try {
            //code...

            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $request->post_id;
            $comment->commenter_name = $request->commenter_name;
            $comment->content = $request->content;;
            $comment->save();
            
            DB::commit();

            $response_data['message'] = 'success';
            $response_data['comment'] = $comment;
            
            return response()->json(['data' => $response_data], 200);   

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
