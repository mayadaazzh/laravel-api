<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => "the datas has been get",
            'data' => $users,
        ], 200);
    }

    public function show($id){
        $users = User::find($id);
        if($users){
            return response()-> json([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $users

            ], 200);
        }else{
            return response() -> json([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ]);
        }
    }
    // public function store($id) {
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
}
