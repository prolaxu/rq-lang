<?php

namespace App\Http\Controllers;

use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Version::limit(10)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $Version=new Version();
            $request->version ? $Version->version = $request->version :null;
            
            if($Version->save()) {
                return response()->json(['status'=>'success','message'=>'Version Was Updated.']);
            }
        } catch (\Exception $e) {
           
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Version  $Version
     * @return \Illuminate\Http\Response
     */
    public function show(Version $Version,$id)
    {
        return Version::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Version  $Version
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Version $Version,$id)
    {
        //
        try {
            $Version=Version::findOrFail($id);
            $request->version ? $Version->version = $request->version :null;
            if($Version->save()) {
                return response()->json(['status'=>'success','message'=>'Version Was Updated.']);
            }
        } catch (\Exception $e) {
           
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Version  $Version
     * @return \Illuminate\Http\Response
     */
    public function destroy(Version $Version,$id)
    {
        try {
            $Version=Version::findOrFail($id);
            if($Version->delete()) {
                return response()->json(['status'=>'success','message'=>'Version Was Deleted.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
}