<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    use HasFactory;
    // specify the table, primary key and if not autoincremening make it false
    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $guarded = [];  //turns off massasign protection for all or: protected $fillable = ['company_id','name','vorname'...];
    //public $incrementing = false;
    public $timestamps = false;
}
