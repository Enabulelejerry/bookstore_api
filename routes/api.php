<?php

use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CreateStoreController;
use App\Http\Controllers\StoreController;
// use App\Http\Controllers\SingleUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/






Route::middleware('auth:api')->prefix('v1')->group(function(){
     
     
   Route::group(['prefix'=>'me'],function(){
     Route::get('/profile','App\Http\Controllers\UserProfileController@index');
     Route::post('/profile','App\Http\Controllers\UserProfileController@store');
     Route::put('/profile','App\Http\Controllers\UserProfileController@update');
     Route::delete('/profile','App\Http\Controllers\UserProfileController@destroy');
    // Route::post('/salary/paid/{id}', [App\Http\Controllers\Api\SalaryController::class, 'paid']);
   });

    Route::group(['middleware' =>['role:super-admin|book-owner'], 'prefix' =>'admin'], function(){
      // Route::ApiResource('users', UserController::class);
      Route::apiResource('/users', AdminUserController::class);
      Route::post('/users/suspend/{id}', [AdminUserController::class,'suspend']);
      Route::post('/users/activate/{id}', [AdminUserController::class,'activate']);

      Route::get('roles/{id}', [AdminRoleController::class, 'show']);
      Route::get('permission/{id}', [AdminPermissionController::class, 'show']);
      Route::put('/update/role/{id}', [AdminRoleController::class, 'changeRole']);
    });
      //create store
    Route::group(['middleware' =>['role:book-owner'], 'prefix' =>'owner'], function(){
      // Route::ApiResource('users', UserController::class);
      Route::post('/stores/create', [CreateStoreController::class,'store']);
   
    });

    Route::group(['middleware' =>['role:book-owner','isStoreOwner'], 'prefix' =>'owner'], function(){
      // Route::ApiResource('users', UserController::class);
      Route::apiResource('/stores', StoreController::class,['except' =>['store']]);
      Route::apiResource('/stores/{store}/brands', BrandController::class);
    });

    

    Route::ApiResource('/books',BooksController::class);

    Route::ApiResource('/authors',AuthorsController::class);
   
 
   


    //   Route::get('/authors/{author}',[AuthorsController::class,'show']);
    // // Route::get('/authors/{author}',AuthorsController::class,'show');

    // Route::get('/authors',[AuthorsController::class,'index']);
});
 


