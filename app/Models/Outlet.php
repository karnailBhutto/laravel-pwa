<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    //use HasFactory;
	
	protected $fillable = [
        'outlet_id', 'outlet_sname', 'outlet_owner','outlet_contact','outlet_region','outlet_province','outlet_district','outlet_postal','outlet_address','created_by', 'updated_by','created_at', 'updated_at', 'team_id','outlet_type'
    ];
}
