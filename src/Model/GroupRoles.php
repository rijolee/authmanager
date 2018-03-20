<?php

namespace rijolee\AuthManager\Model;

use Illuminate\Database\Eloquent\Model;

class GroupRoles extends Model
{
    protected $table = 'grouproles'; 
	protected $primaryKey = 'grouproles_id';
    protected $casts = ['grouproles_id' => 'string'];
    
	protected $fillable = [
        'grouproles_id','grouproles_nm','grouproles_desc'
    ];

	public function hasuser()
    {
    
        return $this->belongsToMany('rijolee\AuthManager\Model\Users', 'usergroups','grouproles_id','user_id');
    
    }

    public function menus()
    {
    
        return $this->belongsToMany('rijolee\AuthManager\Model\Menus', 'menugroups','grouproles_id','menu_id');
    
    }

   

    public function hasmenus()
    {
    
        return $this->belongsToMany('rijolee\AuthManager\Model\Menus', 'eventmenugroups','grouproles_id','menu_id')->withPivot('event_id');
    
    }


    public function usergroup(){
        return $this->hasMany('rijolee\AuthManager\Model\UserGroup', 'grouproles_id');
    }

    public function eventmenugroup(){
        return $this->hasMany('rijolee\AuthManager\Model\EventMenuUserGroup', 'grouproles_id');
    }

    

    
}
