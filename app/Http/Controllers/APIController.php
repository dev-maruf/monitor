<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Device;
use App\Data;

class APIController extends Controller
{
    public function getData(Request $request)
    {
        // dd($request);
        if(!$request->has('key')){
            return response()->json([
                "message" => "No Key"
            ]);
        }
        if($request->key == null){
            return response()->json([
                "message" => "Key cannot null"
            ]);
        }
        if(($request->r == null)||($request->s == null)||($request->t == null)){
            return response()->json([
                "message" => "Parameter incomplete"
            ]);
        }
        $dev = Device::where('key', $request->key);
        $count = $dev->count();
        if($count != 1){
            return response()->json([
                "message" => "Key not found"
            ]);
        }
        $device = $dev->first();
        $date = str_replace("|", " ", $request->time);
        $date = Carbon::parse($date);
        
        $device->data()->create([
            'r' => $request->r,
            's' => $request->s,
            't' => $request->t,
            'time' => $date->format('Y-m-d H:i:s')
        ]);

        return response()->json([
            "message" => "Succesfull create data"
        ]);
        // return $request;
    }
}
