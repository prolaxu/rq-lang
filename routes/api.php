<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LangController;
use App\Models\Lang;
use App\Models\Version;


Route::post('/v1/login',[LoginController::class,'login']);
// Route::post('/register',[LoginController::class,'login']);

// Route::post('/register', 'LoginController@register');
Route::middleware('auth:api')->prefix('/v1')->group(function () {
    Route::get('/lang/{keyName}',[LangController::class,'show']);
    Route::get('/langs',[LangController::class,'index']);
    Route::put('/lang',[LangController::class,'create']);
    Route::patch('/lang/{id}',[LangController::class,'update']);
    Route::delete('/lang/{id}',[LangController::class,'destroy']);

    


    Route::get('/version', function () {
        try {
            $Version=new Version();
            $Version->version = '0.01';
            if($Version->save()) {
                return response()->json(['status'=>'success','message'=>'Version Was Updated.',
                'data'=>Version::findOrFail($id)
            ]);
            }
        } catch (\Exception $e) {
           
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    });
    Route::get('/update',function(){
        $lang= new LangController();
        $lang->update_version();
    });

});
