<?php

namespace rijolee\AuthManager\Model;

use Illuminate\Database\Eloquent\Model;

class MenuUserGroup extends Model
{
    protected $table = 'menugroups'; 
	
	protected $fillable = [
        'menu_id','grouproles_id'
    ];

    public function group()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\GroupRoles');
    }

    public function menu()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\Menus');
    }

}
