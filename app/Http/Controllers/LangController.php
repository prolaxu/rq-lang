<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use Illuminate\Http\Request;
use App\Models\Version;

class LangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //code...
            return response()->json(
                [
                    'status'=>'success',
                    'message'=>'List of all Welcome!',
                    'data'=>Lang::where('user_id',auth('api')->user()->id)->get()
                ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status'=>'success',
                    'message'=>'List of all Welcome!',
                    'data'=>$e->getMessage()
                ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $Lang=new Lang();
            $request->lang_code ? $Lang->lang_code = $request->lang_code :null;
            $request->privacyPolicy ? $Lang->privacyPolicy = $request->privacyPolicy :null;
            $request->appName ? $Lang->appName = $request->appName :null;
            $request->welcome ? $Lang->welcome = $request->welcome :null;
            $Lang->user_id = auth('api')->user()->id;
            
            if($Lang->save()) {
                $this->update_version();
                return response()->json(['status'=>'success','message'=>'Lang Was Added.']);
            }
        } catch (\Exception $e) {
           
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lang  $Lang
     * @return \Illuminate\Http\Response
     */
    public function show($keyName)
    {
        // return auth('api')->user()->id;
        try {
            //code...
            return response()->json(
                [
                    'status'=>'success',
                    'message'=>'List of all Welcome!',
                    'data'=>Lang::where('user_id',auth('api')->user()->id)->where('lang_code', $keyName)->get()[0]
                ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status'=>'success',
                    'message'=>'List of all Welcome!',
                    'data'=>$e->getMessage()
                ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lang  $Lang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $keyName)
    {
        //
        try {
            $Lang=Lang::where('user_id',auth('api')->user()->id)->where('lang_code', $keyName)->get()[0];
            $request->lang_code ? $Lang->lang_code = $request->lang_code :null;
            $request->privacyPolicy ? $Lang->privacyPolicy = $request->privacyPolicy :null;
            $request->appName ? $Lang->appName = $request->appName :null;
            $request->welcome ? $Lang->welcome = $request->welcome :null;

            if($Lang->save()) {
                $this->update_version();
                return response()->json(['status'=>'success','message'=>'Lang Was Updated.']);
            }
        } catch (\Exception $e) {
           
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lang  $Lang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Lang=Lang::where('user_id',auth('api')->user()->id)->where('lang_code', $keyName)->get()[0];
            if($Lang->delete()) {
                $this->update_version();
                return response()->json(['status'=>'success','message'=>'Lang Was Deleted.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
    public function update_version(){
        $Version=Version::findOrFail(1);
        $Version->version = (float) $Version->version+0.01;
        $Version->save();
    }
}