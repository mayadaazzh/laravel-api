<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required',
            'user_id' => 'required',

        ]);

        $comment = Comment::create($request->all());
        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'comments_content' => 'required',
        ]);
    
        try {
            $comment = Comment::find($id);
    
            if ($comment) {
                $comment->comments_content = $request['comments_content'];
                $comment->save();
                return response()->json([
                    'status' => true,
                    'message' => "the data has been updated",
                    'data' => $comment
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
        $comment = Comment::find($id);

        try {
            if ($comment) {
                $comment->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'the comment id ' . $id . ' has been deleted',
                ], 202);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'comment with id ' . $id . ' not found.',
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
