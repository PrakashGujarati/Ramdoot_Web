<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public static function getPermissios($module_name){
    	$get_data = Permission::where(['module_name' => $module_name])->get();
    	$data=[];
    	if(count($get_data) > 0){
    		foreach ($get_data as $value) {
    			$data[] = ['id' => $value->id,'name' => $value->name];
    		}
    	}
    	return $data;
    }
}
