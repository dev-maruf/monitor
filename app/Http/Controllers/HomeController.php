<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Device;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function addDevice(Request $request)
    {
        $device = Auth::user()->device()->create([
            'name' => $request->name,
            'key' => $request->key
        ]);
        return redirect()->back();
    }

    public function editDevice(Request $request)
    {
        $device = Device::find($request->id)->update([
            'name' => $request->name,
            'key' => $request->key
        ]);
        return redirect()->back();
    }

    public function deleteDevice(Request $request)
    {
        $device = Device::find($request->id)->delete();
        return "success";
    }

    public function logViewer($key)
    {
        $dev = Device::where('key', $key);
        $count = $dev->count();
        if($count != 1){
            return redirect()->route('home');
        }
        return view('log', compact('key'));
    }

    public function getGraph($key)
    {
        $main = Device::where('key', $key)->first();
        $ret = [];
        foreach($main->data as $data){
            $i = [
                strtotime($data->time)*1000,
                $data->r,
                $data->s,
                $data->t
            ];
            array_push($ret, $i);
        }

        return $ret;
    }

    public function showGraph($key)
    {
        return view('graph', compact('key'));
    }
}
