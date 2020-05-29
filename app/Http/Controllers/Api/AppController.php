<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Event;
use App\Models\Post;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AppController extends Controller
{
    public function data_counts(){
        return [
            'data' => [
                'students' => Student::count(),
                'posts' => Post::count(),
                'events' => Event::count(),
                'semester' => '2<sup>nd</sup> Sem 2019-2020',
                'programs' => Program::count()
            ]
        ];
    }


    public function update_profile(Request $request){

        $user =  $request->user();

        $rules = [
            'username' => [
                'required',
                'min:3',
                'max:20',
                Rule::unique('users')->ignore($user->id)
            ],
            'new_password' => 'nullable|min:5|max:20',
            'confirm_new_password' => [
                'same:new_password'
            ],
            'password' => 'required'
        ];

        $request->validate($rules);

        if($request->user()->checkPassword($request->password)){
            $user->username = $request->username;
            if($request->new_password)
                $user->password = bcrypt($request->new_password);

            $user->save();
        }
        else
            return response()->json([
                'message' => 'Authentication failed'
            ], 403);

        

        return new UserResource($user);
    }

    public function upload_profile_picture(Request $request){

        $rule = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $user = $request->user();

        $request->validate($rule); 
        
        // Get image file
        $image = $request->file('image');
        $name = $user->id . date('Ymdhis');
        $folder = 'images/profile-pictures/';
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();



        $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension());


        $prevImage = $user->profile_image;
        

        $user->update([
            'profile_image' => $filePath
        ]);

        if(Storage::exists($prevImage))
            Storage::delete($prevImage);


        return [
            'data' => Storage::url($filePath)
        ];
    }

    public  function upload(Request $request){

        $image = $request->file('image');
        $name = 'post-'. date('Ymdhis');
        $folder = 'images/posts/';
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();


        $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension());


        return [
            'data' => [
                'image_url' => Storage::url($filePath)
            ]
        ];
    }
}
