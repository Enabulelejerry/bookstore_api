<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminRoleController extends Controller
{

    public function show($id)
    {
       if(!$user = User::find($id)){

        throw new NotFoundHttpException('User Not Found');
       }
        
       return $user->getRoleNames();
    }

   
    public function changeRole(Request $request, $id){
        if(!$user = User::find($id)){

            throw new NotFoundHttpException('User Not Found');
           }

           try {
            $user->syncRoles([$request->role]);
           } catch (HttpException $th) {
            throw $th;
           }
            
           
           return response()->json([
            'message' => 'User roles are updated',
            'roles' => $user->role
           ])->setStatusCode(200);
    }

}
