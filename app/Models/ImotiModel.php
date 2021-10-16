<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImageModel;
use App\Models\AreaModel;
use App\Models\User;

class ImotiModel extends Model
{
    //public $paginateDash = 20;

    use HasFactory;
    // specify the table, primary key and if not autoincremening make it false
    protected $table = 'imoti';
    protected $primaryKey = 'id';
    protected $guarded = [];  //turns off massasign protection for all or: protected $fillable = ['company_id','name','vorname'...];
    //public $incrementing = false;
    //public $timestamps = false; //By default laravel will expect created_at & updated_at column in your table. By making it to false it will override the default setting.


    public function __construct() {
        
    }


    public function area(){
        return $this->hasOne(AreaModel::class, 'id', 'area_id');
    }


    public function agent(){
        return $this->hasOne(User::class, 'id', 'agent_id');
    }


    public function images(){
        return $this->hasMany(ImageModel::class, 'imot_id', 'id')->orderBy('position');
    }


    public function getImot($id, $visible)
    {     
        $imot = ImotiModel::where('id', $id)
                        ->with('images')
                        ->with('area')
                        ->with('agent')
                        ->get($visible);
        return $imot;
    }
    

    public static function homeImoti($paginate, $visible)
    {     
        $active = ImotiModel::Where('deleted', 0)
                            ->where(function ($query) {
                                $query->where('status', 'Продажба')
                                ->orWhere('status', 'Наем')
                                ->orWhere('status', 'Отдаден')
                                ->orWhere('status', 'Продаден');
                            })
                            ->with('images')
                            ->with('area')
                            ->with('agent')
                            ->paginate($paginate, $visible);
        //dd($active);
        return $active;
    }
    

    public static function topImoti($visible)
    {        
        $top = ImotiModel::where('top', 1)
                        ->Where('deleted', 0)
                        ->where(function ($query) {
                            $query->where('status', 'Продажба')
                                ->orWhere('status', 'Наем');
                        })->get($visible);
        return $top;
    }
    

    private static $searchCriteria = [
        'agent' => ['agent', '='],
        'status' => ['status', '='],
        'pricemin' => ['price', '>='],
        'pricemax' => ['price', '<='],
        'sizemin' => ['size', '>='],
        'sizemax' => ['size', '<=']
    ];

    public static function getQueryHome2($request, $paginate, $visible)
    {
        $filter = $request->all();
        if(!$filter){
            return self::homeImoti($paginate, $visible);
        } else {        
            $search = ImotiModel::query();
            foreach ($filter as $key => $value){
                if(isset($filter['refnum'])){
                    $search = $search->where('id', '=', $filter['refnum']);
                } else {                  
                    foreach (self::$searchCriteria as $field => $cfg) {
                        if(isset($filter[$field])) {
                            $search = $search->where($cfg[0], $cfg[1], $filter[$field]);
                        }
                    }
                }
            }
        }
    }

    private static function smth($type, $items) {
        return $search->Where(function($query) use ($items) {
            foreach ($items  as $key => $value) { 
            $query->orWhere($type, '=', $value);
            }
        });
    }

    public static function getQueryHome($request, $paginate, $visible)
    {
        $filter = $request->all();
        if(!$filter){
            return self::homeImoti($paginate, $visible);
        } else {        
            $search = ImotiModel::query();
            foreach ($filter as $key => $value){
                if(isset($filter['refnum'])){
                    $search = $search->where('id', '=', $filter['refnum']);
                } else {                    
                    if(isset($filter['agent'])){
                        $search = $search->where('agent', '=', $filter['agent']);
                    }
                    if(isset($filter['status'])){
                        $search = $search->where('status', '=', $filter['status']);
                    }
                    if(isset($filter['pricemin'])){
                        $search = $search->where('price', '>=', $filter['pricemin']);
                    }
                    if(isset($filter['pricemax'])){
                        $search = $search->where('price', '<=', $filter['pricemax']);
                    }
                    if(isset($filter['sizemin'])){
                        $search = $search->where('size', '>=', $filter['sizemin']);
                    }
                    if(isset($filter['sizemax'])){
                        $search = $search->where('size', '<=', $filter['sizemax']);
                    }                
                    if(isset($filter['type'])){    
                        $types = $filter['type'];
                        $search = $search->Where(function($query) use ($types){
                            foreach ($types  as $key => $value) { 
                            $query->orWhere('type', '=', $value);
                            }
                        });
                    }                
                    if(isset($filter['area_id'])){    
                        $areas = $filter['area_id'];
                        $search = $search->Where(function($query) use ($areas){
                            foreach ($areas  as $key => $value) { 
                            $query->orWhere('area_id', '=', $value);
                            }
                        });
                    }                
                    if(isset($filter['city'])){    
                        $city = $filter['city'];
                        $search = $search->Where(function($query) use ($city){
                            foreach ($city  as $key => $value) { 
                            $query->orWhere('city', '=', $value);
                            }
                        });
                    }                
                    if(isset($filter['material'])){    
                        $materials = $filter['material'];
                        $search = $search->Where(function($query) use ($materials){
                            foreach ($materials  as $key => $value) { 
                            $query->orWhere('material', '=', $value);
                            }
                        });
                    }
                }            
                
                $result = $search->select($visible)
                            ->Where('deleted', 0)
                            ->with('images')
                            ->with('area')
                            ->with('agent')
                            ->paginate($paginate, $visible);

                //dd($result);
                return $result;
            } 
        }
        
    }


    public static function getQueryDashboard($request, $agent, $visible)
    {   //dd($request, $agent, $visible);
        $filter = $request->all();
        $search = ImotiModel::query();
        if($agent->role != 'admin'){
            $filter = ['deleted' => 0, 'agent_id' => $agent->id];
        } else if(empty($filter)){
            $filter = ['noFilter' => 0];
        } //dd($filter);
        foreach ($filter as $key => $value){
            if(isset($filter['refnum'])){
                $search = $search->where('id', '=', $filter['refnum']);
            } else if(isset($filter['noFilter'])){
                $search = $search->where('id', '>', 0);
            } else { 
                if(isset($filter['agent_id']) && $filter['agent_id']!= 0){
                    $search = $search->where('agent_id', '=', $filter['agent_id']);
                } 
                if(isset($filter['deleted'])){
                    $search = $search->where('deleted', '=', $filter['deleted']);
                }
                if(isset($filter['private'])){
                    $search = $search->where('private', '=', $filter['private']);
                }
                if(isset($filter['status']) && $filter['status'] == 'active'){
                    $search = $search->where(function ($query) {
                                        $query->where('status', 'Продажба')
                                        ->orWhere('status', 'Наем')
                                        ->orWhere('status', 'Отдаден')
                                        ->orWhere('status', 'Продаден');
                                    });
                }/*
                if(isset($filter['type'])){    
                    $types = $filter['type'];
                    $search = $search->Where(function($query) use ($types){
                        foreach ($types  as $key => $value) { 
                          $query->orWhere('type', '=', $value);
                        }
                    });
                }     */
            }            
            
            $result = $search->select($visible)
                        ->with('area')
                        ->with('agent')
                        ->with('images')
                        ->get($visible);
                        //->paginate($paginate, $visible);

            //dd($result, $result[1]->images, $result[1]->agent);      
            return $result;
        } 

        
    }


    public static function getAllCount(){
        return ImotiModel::count();
    }
    
    public static function getMineCount($agent){ 
        if($agent->role == 'admin'){
            return ImotiModel::where('agent_id', $agent->id)->count();
        } else {
            return ImotiModel::where('agent_id', $agent->id)->Where('deleted', 0)->count();
        }
    }
    
    public static function getActiveCount($agent_id){ 
        $query = ImotiModel::query();
        // Ако няма избран агент, показва за всички
        if($agent_id!=0){ 
            $query = $query->where('agent_id', $agent_id); 
        } 
        $query = $query->Where('deleted', 0);        
        $query = $query->where(function ($query) {
            $query->where('status', 'Продажба')
            ->orWhere('status', 'Продаден')
            ->orWhere('status', 'Наем')
            ->orWhere('status', 'Отдаден');
        });
        return $query->count();
    }
    
    public static function getInactiveCount($agent_id){ 
        $query = ImotiModel::query();
        // Ако няма избран агент, показва за всички
        if($agent_id!=0){ 
            $query = $query->where('agent_id', $agent_id); 
        } 
        $query = $query->Where('deleted', 0);       
        $query = $query->where(function ($query) {
            $query->where('status', 'Обява')
            ->orWhere('status', 'Обаждане')
            ->orWhere('status', 'Оглед')
            ->orWhere('status', 'Чернова');
        });
        return $query->count();
    }
    
    public static function getPrivateCount($agent_id){
        $query = ImotiModel::query();
        // Ако няма избран агент, показва за всички
        if($agent_id!=0){ 
            $query = $query->where('agent_id', $agent_id); 
        } 
        $query = $query->Where('private', 1);

        return $query->count();
    }
    
    public static function getDeletedCount($agent_id){
        $query = ImotiModel::query();
        // Ако няма избран агент, показва за всички
        if($agent_id!=0){ 
            $query = $query->where('agent_id', $agent_id); 
        } 
        $query = $query->Where('deleted', 1);
        
        return $query->count();
    }




/*
    public static function imoti($dash, $paginate)
    {   if($dash==1){
            $imoti = ImotiModel::paginate($paginate);
        }else{
            $imoti = ImotiModel::where('status', '!=', 'Чернова')->where('top' , 0)->paginate($paginate);
        }     
        
        return $imoti;
    }

    public static function dashImoti($agent){ 
        if($agent == 'admin')
        {
            $imoti = ImotiModel::paginate($this->paginateDash);
        } else { 
            $imoti = ImotiModel::where('agent_id', $agent)->paginate(20); //dd($imoti);
        }        
        return $imoti;
    }

     public function imot($id)
    {
        
        $imot = ImotiModel::find($id);
        return $imot;
    }

    public function agentsImoti($id=0)
    {
        
        $imoti = ImotiModel::where('agent_id', $id)->get();
        return $imoti;
    }

    public function count()
    {        
        return Model::count();
    }

    public static function homeImotiProdajba($paginate, $visible)
    {        
        $active = ImotiModel::where('status', 'Продажба')
                            ->paginate($paginate, $visible);
        return $active;
    }

    public static function homeImotiNaem($paginate, $visible)
    {        
        $active = ImotiModel::where('status', 'Наем')
                            ->paginate($paginate, $visible);
        return $active;
    }*/
}
