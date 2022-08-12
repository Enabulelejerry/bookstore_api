<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$user = auth()->user()){
            throw new NotFoundHttpException('User not found');
        }
        $stores = Store::with('owner','users')->where('owner_id',$user->id)->get();

        return $stores;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          
        if(!$user = auth()->user()){
            throw new NotFoundHttpException('User not found');
        }
        $store = Store::with('owner','users')->where('owner_id',$user->id)->find($id);

        return $store;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStoreRequest  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$user = auth()->user()){
            throw new NotFoundHttpException('User not found');
        }
        $store = Store::where('owner_id',$user->id)->find($id);
        //dd($store->toArray());

        if(!$store){
            throw new NotFoundHttpException('Store does not exist');
        }
        
        $validator = Validator::make($request->all(),[
          
            'name' => 'required|string|min:3|max:30',
            'details' => 'required|string|min:3',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $store->name=$request->name;
        $store->details=$request->details;
        if($store->save()){
           
            $response = [
                'message' => 'Store Updated Succefully',
                'id' => $store->id
            ];

            return response()->json($response);
        }
        return response()->json(['message' =>'Nothing to update'],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if(!$user = auth()->user()){
            throw new NotFoundHttpException('User not found');
        }
        $store = Store::where('owner_id',$user->id)->find($id);

        

        try {
            $store->delete();
        } catch (HttpException $th) {
            throw $th;
        }
        
        $response = [
            'message' => 'Store deleted Succefully',
            'id' => $id
        ];

        return response()->json($response);
        
    }
}
