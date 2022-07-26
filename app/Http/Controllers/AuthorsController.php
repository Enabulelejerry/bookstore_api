<?php

namespace App\Http\Controllers;

use App\Models\Author;
// use App\Http\Requests\StoreAuthorRequest;
 use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return AuthorResource::collection(Author::all());
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
     * @param  \App\Http\Requests\StoreAuthorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorRequest $request)
    {
        // $faker = \Faker\Factory::create(1);
        $author = Author::create([
          'name' => $request->name
        ]);
       
        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
    //    $authorname = Author::find($author);

    //    return  response()->json([
    //       'data' =>[
    //         'id' => $author->id,
    //         'type'=>'Authors',
    //          'attributes' => [
    //             'name' => $author->name,
    //             'created_at' => $author->created_at,
    //             'updated_at' => $author->updated_at,
    //          ]
    //       ]
    //    ]);
      
     return new AuthorResource($author);
    //  return $author->book;
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    public function update(AuthorRequest $request, $id)
    {
       
        // $validateData = $request->validate([
        //     'name' => 'required|unique:authors|max:255'
            
        // ]);
       
      $updatename = Author::find($id);
      $updatename->name = $request->input('name');
      $updatename->update();
      return new AuthorResource($updatename);

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response (null,204);
    }
}
