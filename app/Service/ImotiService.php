<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Models\ImotiModel;
use App\Models\AreaModel;
use App\Models\User;
use Auth;

class ImotiService
{
    public $paginateHome = 18;
    public $paginateDash = 20;
    public $visibleImot = ['id', 'title', 'text', 'status', 'top', 'city', 'area_id', 'type', 'price', 'size', 'floor', 'floors', 'material', 'view', 'options', 'agent_id'];
    public $visibleImoti = ['id', 'title', 'top', 'status', 'city', 'area_id', 'agent_id', 'type', 'price', 'size', 'floor', 'floors', 'material', 'view', 'created_at'];
    public $forbiden = ['address', 'phone', 'owner', 'notes'];


    // final
    public function getUser()
    {
        // Check is user logged in
        if (Auth::user()) {    
            $user = Auth::user();
        } else {
            $user = 'guest';
        }
        return $user;
    }

    public function sidebarStats(){
        $agent = auth()->user();

        if(Auth::user()->role == 'admin'){
            $agents = User::all()->count();
            $all = ImotiModel::getAllCount(); 
        } else {
            $agents = NULL;
            $all = NULL;
        }
        $mine = ImotiModel::getMineCount($agent);
        $stats = compact('all', 'mine', 'agents', 'agent');//dd($stats);
        return $stats;
    }

    public function privateStats($agent_request){ 
        // TODO if session agent_id replace $agent_request
        $active = ImotiModel::getActiveCount($agent_request);
        $inactive = ImotiModel::getInactiveCount($agent_request);
        $private = ImotiModel::getPrivateCount($agent_request);
        $deleted = ImotiModel::getDeletedCount($agent_request);  

        $stats = compact('active', 'inactive', 'private', 'deleted');
        return $stats;
    }
    
    // final
    public function getPage($page)
    {       
        if($page == "/"){
            $path['page'] = "home";
            $path['tpl'] = "home";
        } else if($page == "imoti" ) {
            $path['page'] = "imoti";
            $path['tpl'] = "imoti";
        } else if( $page == "imoti/naem" ) {
            $path['page'] = "imoti/naem";
            $path['tpl'] = "imoti";
        } else if($page == "imoti/prodajba") {
            $path['page'] = "imoti/prodajba";
            $path['tpl'] = "imoti";
        } else if($page == "dashboard/imoti") {
            $path['page'] = "dashboard/imoti";
            $path['tpl'] = "vendor/adminlte/partials/dashboard/imoti";
        } else if($page == "dashboard") {
            $path['page'] = "dashboard";
            $path['tpl'] = "vendor/adminlte/partials/dashboard/dashboard";
        } else if(strpos($page, 'dashboard/imot/') !== false) {
            $path['page'] = $page;
            $path['tpl'] = "vendor/adminlte/partials/".$page;
        }
        return $path;
    }

    public function getDashStats( $page ){
       $agent = auth()->user();
       
        if($agent->role == 'admin' ){ 
            $agents = count(User::all());
            $all = ImotiModel::getAllCount(); 
            //$mine = ImotiModel::getMineCount($agent);
        } else { 
            $agents = NULL;
            $all = NULL;
            //$mine = ImotiModel::getMineCount($agent);
        }             
        $mine = ImotiModel::getMineCount($agent);  
        /*
        if($page['page'] == 'dashboard/imoti' || $page['page'] == 'dashboard'){ 
            if(!isset($all)){
                $all = ImotiModel::getAllCount();
            }    */                  
            $active = ImotiModel::getActiveCount($agent->id);
            $private = ImotiModel::getPrivateCount($agent->id);
            $deleted = ImotiModel::getDeletedCount($agent->id);  
        /*} else {
            $active = NULL;
            $private = NULL;
            $deleted = NULL;
        }       */
        
        $stats = compact("all", "mine", "active", "private", "deleted", "agents", "agent");
        //$stats = compact("active", "private", "deleted");
        //dd($stats, 'getDashStats/imotiService' );
        return $stats;
    }

    

    // final
    public function getTop()
    {   //dd(ImotiModel::topImoti($this->visibleImoti));
        return ImotiModel::topImoti($this->visibleImoti);
    }

    // final
    public function getActive($page, $agent)
    {
        //dd($page);
        if($page == 'imoti/naem'){
            return ImotiModel::homeImotiNaem($this->paginate, $this->visibleImoti);
        } else if($page == 'imoti/prodajba'){
            return ImotiModel::homeImotiProdajba($this->paginate, $this->visibleImoti);
        } else {
            return ImotiModel::homeImoti($this->paginate, $this->visibleImoti);
        } 
    }

    public function getImotiFiltar(){
        //$data = request()->validate([
        //  'search' => 'required|min:2|max:100'
        //]);
  
        //$pieces = explode(" ", $data['search']);
        $dbFields = ['imoti.id', 'type', 'price', 'size', 'agent_id', 'status', 'imoti.area_id'];
        $pieces = ['3 Стаен', 'продажба'];
  
        $search = ImotiModel::query()  ;
        foreach ($pieces as $key => $piece) {
              //$search = $search->orWhere('firma1', "LIKE", "%{$piece}%");
              $search = $search->Where(function($query) use ($dbFields, $piece){
                          foreach ($dbFields as $key => $dbField) {
                            $query->orWhere($dbField, 'LIKE', "%{$piece}%");
                          }
                        });
        }
          
        $result = $search->select('imoti.id', 'type', 'price', 'size', 'agent_id', 'status', 'area_id')
                        //->join('area', 'area_id', '=', 'area.id')
                        ->with('area')
                        ->with('agent')
                        ->get();
        //$result = $result->makeHidden($this->forbiden);
        //$count = $result->count();
        //return view('search', compact('result', 'srch', 'count'));
        return $result;
        //return  $search->join('kontakt', 'company.id', '=', 'kontakt.company_id')->with('contacts')->with('conversations')->toSql();
        //return $search->toSql();
        //dd($result);
      } // END search
      
}
