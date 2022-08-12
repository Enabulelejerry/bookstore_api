<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::with('roles')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $Validator = Validator::make($request->all(),[
        'email' => 'required|email|unique:users,email|max:30',
         'name' => 'required|string|min:3|max:30',
         'firstname' => 'required|string|min:3|max:30',
         'lastname' => 'required|string|min:3|max:30',
         'gender' => 'required|string'
     ]);

     if($Validator->fails()){
        response()->json(['errors'=> $Validator->errors()]);
     }


     try {
        $user= User::firstorCreate(['email'=>$request->email],[

            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make('123456')
         ]);
    
    
         $user_profile = UserProfile::updateOrCreate(['user_id' =>$user->id],
         [
           'firstname' => $request->firstname,
           'lastname' => $request->lastname,
           'gender' => $request->gender,
           'active' => true
         ]
       );
      
       $user->assignRole('book-owner');
       
     } catch (HttpException $th) {
        throw $th;
     }

     return response()->json([
        'message' => 'User Created Successfully',
        'user' => $user,
        'user profile details' => $user_profile,
      ]);

   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $user = User::find($id)){
            throw new NotFoundHttpException('User not found with id =' . $id);
        }

        return new UserResource($user);
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
      $validator =  Validator::make($request->all(),[
        'firstname' => 'required|string|min:3|max:30',
        'lastname' => 'required|string|min:3|max:30',
         'gender' => 'required|string',
     ]);

     if($validator->fails()){
        return response()->json(['errors'=> $validator->errors()]);
     }

      if(! $user = User::find($id)){
        throw new NotFoundHttpException('User not found with id =' . $id);
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

   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::find($id);
      $user->delete();

      return response()->json([
        'messsage' => 'User deleted successfully',
        'id' => $id,
      ]);

    }


    public function suspend($id){
        
      if(! $user = User::find($id)){
        throw new NotFoundHttpException('User not found with id =' . $id);
    }
    
   try {
    
    $user = UserProfile::updateOrCreate(['user_id'=>$user->id],[
      'active' =>false
    ]);


   } catch (HttpException $th) {
      throw $th;
   }
   

   return response()->json([
    'messsage' => 'User suspended successfully',
    'id' => $id,
  ]);
     
    }


    public function activate($id)
    {
      if(! $user = User::find($id)){
        throw new NotFoundHttpException('User not found with id =' . $id);
    }

    try {
    
      $user = UserProfile::updateOrCreate(['user_id'=>$user->id],[
        'active' =>true
      ]);
  
  
     } catch (HttpException $th) {
        throw $th;
     }
     
  
     return response()->json([
      'messsage' => 'User activated successfully',
      'id' => $id,
    ]);
    }
}
