<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermisionResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminPermissionController extends Controller
{
    public function show($id)
    {
       if(!$user = User::find($id)){

        throw new NotFoundHttpException('User Not Found');
       }
        
       //return $user->getAllPermissions();

       //return new PermisionResource($user->getAllPermissions());
       return PermisionResource::collection($user->getAllPermissions());
    }
}
