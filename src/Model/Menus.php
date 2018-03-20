<?php

namespace rijolee\AuthManager\Model;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus'; 
	protected $primaryKey = 'menu_id';
    protected $casts = ['menu_id' => 'string'];
	protected $fillable = [
        'menu_id', 'parent_id','menu_nm','menu_desc','url','system_nm','menu_order','disp_yn'
    ];

    public $incrementing = false;


	public function group()
    {
    
        return $this->belongsToMany('rijolee\AuthManager\Model\GroupRoles', 'menugroups','menu_id','grouproles_id');
    
    }

    public function events()
    {
    
        return $this->belongsToMany('rijolee\AuthManager\Model\Events', 'eventmenus','menu_id','event_id');
    
    }

    public function eventmenus(){
        return $this->hasMany('rijolee\AuthManager\Model\EventMenus', 'menu_id');
    }

    public function eventmenugroup(){
        return $this->hasMany('rijolee\AuthManager\Model\EventMenuUserGroup', 'menu_id');
    }

    public function parent(){
        return $this->belongsToOne(static::class, 'parent_id');
    }

    public function child(){
        return $this->hasMany(static::class, 'parent_id')->orderBy('menu_id', 'asc');
    }

    

}
