<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Exception;
 //use Illuminate\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
        $user= auth()->user();
        return new UserResource($user);

        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $validator =  Validator::make($request->all(),[
            'firstname' => 'required|string|min:3|max:30',
            'lastname' => 'required|string|min:30|max:30',
             'gender' => 'required|string',
         ]);

 
          if($validator->fails()){
             return response()->json(['errors'=> $validator->errors()]);
          }

          try {

            if(!$user = auth()->user()){
                throw new NotFoundHttpException("Üser Not Found");
            }
            UserProfile::updateOrCreate(['user_id' =>$user->id],[
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'gender' => $request->gender,
                'active' => true,
            ]);

          

            return response()->json([
                'Message' => 'Profile Created Successfully',
                'User' => $user,
              ]);
            
          }  catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $validator =  Validator::make($request->all(),[
            'firstname' => 'required|string|min:3|max:30',
            'lastname' => 'required|string|min:3|max:30',
             'gender' => 'required|string',
         ]);

         if($validator->fails()){
            return response()->json(['errors'=> $validator->errors()]);
         }

        try {
           if(!$user = auth()->user()){
            throw new NotFoundHttpException("Üser Not Found");
           }
            
          
        $user_profile = UserProfile::updateOrCreate(['user_id' =>$user->id],
          [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
          ]
        );

         
      return response()->json([
        'Message' => 'Profile Updated Successfully',
        'User' => $user_profile,
      ]);

        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try {
             $user = auth()->user();
             $user->delete(); 
             auth()->logout();

            //  $user = Auth::user();
            //  $user->delete();
            //  Auth::logout();
           
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json([
            'Message' => 'Profile Deleted Successfully',
           
          ]);
    }
}
