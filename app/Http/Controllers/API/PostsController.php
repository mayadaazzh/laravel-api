<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts->loadMissing('writer:id,username'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
            'user_id' => 'required|exists:users,id' 
        ]);

        $post = Post::create($validated);

        return new PostResource($post->loadMissing('writer:id,email,username'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //    public function show($id) {
    //     $checkUser = User::where('id', $id)->first();
    //     $checkPost = Post::where('user_id', $checkUser->id)->get();

    //     try {
    //         if($checkPost && $checkUser){
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => "the data post user_id " . $id . " has been get",
    //                 'data' => $checkPost,

    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => "ada yang salah",

    //             ],404);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'error' => $e->getMessage(),
    //         ], 404);
    //     }
    // }

    public function show($id)
    {
        $post = Post::with('writer:id,email,username')->findOrFail($id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrfail($id);
        $post->update($request->all());

        return new PostResource($post->loadMissing('writer:id,email,username'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrfail($id);
        // $post->delete();

        return new PostResource($post->loadMissing('writer:id,email,username'));

    }
}
