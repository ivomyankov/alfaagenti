<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImotiModel;
use App\Service\ImotiService;
use App\Models\User;
use Auth;

class DashboardController extends ImotiController
{
    protected $imoti;
    public $paginate = 20;

    public function __construct(ImotiService $imoti)
    {
        $this->middleware('auth'); 
        $this->imoti = $imoti;        
    }

    public function getDashboard(Request $request)        
    {           
        $sidebarStats = $this->imoti->sidebarStats(); 
        //if($request->agent_id){
        //    $agent_request = $request->agent_id;
        //} else {  
            $agent_request = $sidebarStats['agent']->id;
        //}
        $privateStats = $this->imoti->privateStats($agent_request); 
        $stats = array_merge($sidebarStats, $privateStats);
        //dd($stats, 'stats');
        // return curent page and its tpl
        //$page = $this->imoti->getPage( $request->path() );           
        //$stats = $this->imoti->getDashStats( $page );   //dd($stats);
        // Redeclare $page to correct blade page name     
        return view('vendor/adminlte/partials/dashboard/dashboard', ['stats' => $stats]);        
    }


    public function getImoti(Request $request)        
    {   
        $sidebarStats = $this->imoti->sidebarStats(); 
        /*if(isset($request->agent_id)){
            $agent_request = $request->agent_id;
        } else {  */
            $agent_request = $sidebarStats['agent']->id;
        //} 
        $privateStats = $this->imoti->privateStats($agent_request); 
        $stats = array_merge($sidebarStats, $privateStats); //dd($stats);
        $agents_list = User::all();
        $imoti = ImotiModel::getQueryDashboard($request, $sidebarStats['agent'], $this->visibleImoti, $agent_request); //dd($imoti);
        // return curent page and its tpl
        //$page = $this->imoti->getPage( $request->path() );           
        //$stats = $this->imoti->getDashStats( $page );  // dd($imoti);
        // Redeclare $page to correct blade page name     
        return view('vendor/adminlte/partials/dashboard/imoti', [ 'imoti' => $imoti, 'stats' => $stats, 'agents_list' => $agents_list]);
        
        
        /*
        $class = substr(strrchr(__CLASS__, "\\"), 1);
        //Pulls data from ImotiService service container
        
        $all = $this->imoti->getimoti($class, $page['page'], $request);
        // Redeclare $page to correct blade page name
        //dd($all);
        return view($page['tpl'], ['imoti' => $all]);*/
    }


    public function getImot(Request $request, $id)
    {           
        $imot = ImotiModel::Where('id', $id)
                        ->Where('deleted', 0)
                        ->with('area')
                        ->with('agent')
                        ->with('images')
                        ->get();
        $page = $this->imoti->getPage( 'dashboard/imot/x' );           
        $stats = $this->imoti->getDashStats( $page );  
        //$request->session()->flash('alert-success', 'test msg');
        return view('vendor/adminlte/partials/dashboard/imot', ['imot' => $imot, 'stats' => $stats]);
    }


    public function test()
    {
        $links = ImotiModel::imoti(1, 2);
        $imoti = $links->makeHidden($this->forbiden)->toArray();
        //dd($imoti);
        return view('vendor/adminlte/dashboard', ['imoti' => $imoti, 'links' => $links->links()]);
    }

    public function switchAgent(Request $request, $id)
    { 
        $request->session()->put('agent_id',$id);
        return redirect()->route('dashImoti');
        //return redirect()->back();
    }

    public function agenti(Request $request)        
    { 
        $sidebarStats = $this->imoti->sidebarStats(); 
        $agent_request = $request->agent_id;
        $privateStats = $this->imoti->privateStats($agent_request); 
        $stats = array_merge($sidebarStats, $privateStats);
        $agenti = User::all();
        return view('vendor/adminlte/partials/dashboard/agenti', ['agenti' => $agenti, 'stats' => $stats]);
    }

    public function ban($id)        
    { 
        User::where('id', $id)->update(['banned'=>1]);
        return redirect()->back();
    }

    public function unban($id)        
    { 
        User::where('id', $id)->update(['banned'=>0]);
        return redirect()->back();
    }
}
