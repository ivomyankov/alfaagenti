<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use DisableAuthorization;
use App\Models\ImotiModel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        $post = ImotiModel::where('id',1)->update(['title'=>'Имот 1a ']);
        return response()->json($post, 201);
    }

    public function test1()
    { //dd('test');
        $post = ImotiModel::find(1);
        return response()->json($post, 200);
        /*return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);*/
    }

    public function test2()
    { //dd('test');
        $post = ImotiModel::find(1); //dd($post);
        return response()->json($post, 200);
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function dashboard()
    {
         return view('admin/dashboard');
    }





}
