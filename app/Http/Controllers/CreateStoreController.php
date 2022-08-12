<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateStoreController extends Controller
{
    public function store(Request $request){
        if(!$user = auth()->user()){
            throw new NotFoundHttpException('User not found');
        }
        
        $rules = [
             
            'name' =>[
                'required',
                'string',
                'min:3',
                'unique:stores,name'
            ],

            'details' =>[
                'required',
                'string',
                'min:3',
    
            ],
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['validation errors'=>$validator->errors()]);
        }

       $store =  $user->stores()->create([
            'name' => $request->name,
            'details' => $request->details,
        ]);

        $response = [
            'message' => 'Store created Succefully',
            'id' => $store->id
        ];

        return response()->json($response);
    }
}
