<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index() {

        // fetch all post
        $posts = Post::where('user_id', Auth::user()->id)->with('comments')->get();
        
        $response_data['message'] = 'success';
        $response_data['posts'] = $posts;
        
        return response()->json(['data' => $response_data], 200);

    }

    // store post 
    public function store(Request $request) {

        // validate incoming request
        $validator = Validator::make($request->all(), [
            // 'user_id'       => ['required', 'exists:users,id', 'integer'],
            'title'         => ['required', 'string', 'max:255'],
            'content'       => ['required', 'string'],
            'author'        => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            $response_data['errors'] = $validator->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }

        DB::beginTransaction();
        try {
            //code...

            $post = new Post();
            $post->user_id = Auth::user()->id;
            $post->title = $request->title;
            $post->content = $request->content;
            $post->author = $request->author;
            $post->save();
            
            DB::commit();

            $response_data['message'] = 'success';
            $response_data['post'] = $post;
            
            return response()->json(['data' => $response_data], 200);   

        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function update(Request $request, $id) {
        $post = Post::find($id);
        if(!$post) {
            return response()->json(['error' => 'Post not found!'], 404);
        }

        // validate incoming request
        $validator = Validator::make($request->all(), [
            'title'         => ['required', 'string', 'max:255'],
            'content'       => ['required', 'string'],
            'author'        => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            $response_data['errors'] = $validator->errors()->all();
            return response()->json(['data' => $response_data], 422);
        }

        try {
            //code...
            $post->title = $request->title;
            $post->content = $request->content;
            $post->author = $request->author;
            $post->save();

            $response_data['message'] = 'Updated Successfully !';
            $response_data['post'] = $post;
            
            return response()->json(['data' => $response_data], 200);   

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function destroy($id) {

        try {
            // find post
            if(!$post = Post::find($id)) {
                $response_data['errors'] = 'post not found';
                return response()->json(['data' => $response_data], 404);
            }

            // delete post from database
            $post->delete($id);

            // response
            $response_data['message'] = 'Post deleted';
            return response()->json(['data' => $response_data], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
