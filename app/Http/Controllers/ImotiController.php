<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ImotiService;
use App\Models\ImotiModel;
use Auth;

class ImotiController extends Controller
{
    public $paginate = 18;
    public $visibleImot = ['id', 'title', 'text', 'status', 'top', 'city', 'area_id', 'type', 'price', 'size', 'floor', 'floors', 'material', 'view', 'options', 'agent_id'];
    public $visibleImoti = ['id', 'title', 'top', 'status', 'city', 'area_id', 'agent_id', 'type', 'price', 'size', 'floor', 'floors', 'material', 'view', 'created_at', 'private', 'deleted'];
    public $forbiden = ['address', 'phone', 'owner', 'notes'];
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $imoti;

    public function __construct(ImotiService $imoti )
    {
        //$this->middleware('auth');
        $this->imoti = $imoti;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
        
    public function getImoti(Request $request)        
    {   
        $top = $this->imoti->getTop();      
        $imoti = ImotiModel::getQueryHome($request, $this->paginate, $this->visibleImoti);
        // return curent page and its tpl
        $page = $this->imoti->getPage( $request->path() );  
        
        // Redeclare $page to correct blade page name     
        return view($page['tpl'], ['top' => $top, 'imoti' => $imoti]);


/*
        // return curent page and its tpl
        $page = $this->imoti->getPage( $request->path() );       
        // Gets this class name only ( no namespace)
        $class = substr(strrchr(__CLASS__, "\\"), 1);
        //Pulls data from ImotiService service container
        
        $all = $this->imoti->getimoti($class, $page['page'], $request);
        // Redeclare $page to correct blade page name
        //dd($all);
        return view($page['tpl'], ['imoti' => $all]);*/
    }


    public function allEstates(Request $request)        
    {   
        return view('imoti',$this->displayData_changeName($request));
    }

    public function allRents(Request $request)        
    {   
        return view('imoti/naem', $this->displayData_changeName($request));
    }

    public function allSales(Request $request)        
    {   
        return view('imoti/prodajba', $this->displayData_changeName($request));
    }

    private function displayData_changeName($request) {
        return [
            'top' => $this->imoti->getTop(),      
            'imoti' => ImotiModel::getQueryHome($request->all(), $this->paginate, $this->visibleImoti)
        ];
    }

    //@TODO
    public function search(Request $request)        
    {   
        $top = $this->imoti->getTop();      
        $imoti = ImotiModel::getQueryHome($request, $this->paginate, $this->visibleImoti);
        return view($page['tpl'], ['top' => $top, 'imoti' => $imoti]);
    }

    //@TODO
    public function sample(Request $request)        
    {   
        $top = $this->imoti->getTop();      
        $imoti = ImotiModel::getQueryHome($request, $this->paginate, $this->visibleImoti);
        return view(
            'some-template',  //'some-template-admin'
            [
                'top' => $top, 
                'imoti' => $imoti,
                'partial1' => [  // include($partial1->template, $partial1->data)
                    'template' => 'template1',
                    'data' => []
                ]
            ]
        );
    }



    public function estateById(Request $request)        
    {   
        $top = $this->imoti->getTop();      
        $imoti = ImotiModel::getQueryHome($request, $this->paginate, $this->visibleImoti);
        return view($page['tpl'], ['top' => $top, 'imoti' => $imoti]);
    }

    public function getHomeImot($id)        
    {      
        $imotInst = new ImotiModel;
        $imot = $imotInst->getimot($id, $this->visibleImoti);  
        return view('imot', ['imot' => $imot[0]]);
    }
    


    public function getImotiFiltar()
    {  
        return $this->imoti->getImotiFiltar();
    }

    public function index()
    {
        return view('home');
    }
}
