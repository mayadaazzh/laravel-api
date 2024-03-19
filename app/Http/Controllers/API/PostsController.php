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
        $posts = Post::with(['writer', 'comments'])->get();

        $mappedData = $posts->map(function ($post) {
            $comments = $post->comments->map(function ($comment) {
                return [
                    'comment' => $comment->comments_content,
                ];
            });

            return [
                'id' => $post->id,
                'title' => $post->title,
                'news_content' => $post->news_content,
                'created_at' => date_format($post->created_at, "Y/m/d H:i:s"),
                'writerFirstName' => $post->writer->firstname,
                'writerLastName' => $post->writer->lastname,
                'comments' => $comments,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => "the datas has been get",
            'data' => $mappedData,
        ], 200);
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

        try {
            $post = Post::create($validated);

            if ($post) {
                return response()->json([
                    'status' => true,
                    'message' => 'The data has been created.',
                    'data' => $post
                ], 202);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create data.',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 404);
        }
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
    //             'error'  => $e->getMessage(),
    //         ], 404);
    //     }
    // }

    public function show($id)
    {
        $post = Post::with('writer', 'comments')->find($id);

        try {
            if ($post) {
                $comments = $post->comments->map(function ($comment) {
                    return [
                        'comment' => $comment->comments_content,
                    ];
                });

                $mappedData = [
                    'id' => $post->id,
                    'title' => $post->title,
                    'news_content' => $post->news_content,
                    'created_at' => date_format($post->created_at, "Y/m/d H:i:s"),
                    'writerFirstName' => $post->writer->firstname,
                    'writerLastName' => $post->writer->lastname,
                    'comments' => $comments,
                ];

                return response()->json([
                    'status' => true,
                    'message' => "Post found.",
                    'data' => $mappedData
                ], 200);
                
            } else {
                // Jika post tidak ditemukan
                return response()->json([
                    'status' => false,
                    'message' => "Post not found.",
                ], 404);
            }
        } catch (Exception $e) {
            // Jika terjadi kesalahan
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
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

        $post = Post::find($id);

        try {
            if ($post) {
                $post->title = $request->title;
                $post->news_content = $request->news_content;
                $post->save();
                return response()->json([
                    'status' => true,
                    'message' => "the data has been updated",
                    'data' => $post
                ], 202);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "ada yang salah",
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        try {
            if ($post) {
                $post->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'the data id ' . $id . ' has been deleted',
                ], 202);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data with id ' . $id . ' not found.',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
