<?php

namespace rijolee\AuthManager\Model;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events'; 
	protected $primaryKey = 'event_id';
    protected $casts = ['event_id' => 'string'];
    
    
	protected $fillable = [
        'event_id','event_nm','event_desc'
    ];

	public function menus()
    {
    
        return $this->belongsToMany('rijolee\AuthManager\Model\Menus', 'eventmenus','event_id','menu_id');
    
    }

    public function eventmenus(){
        return $this->hasMany('rijolee\AuthManager\Model\EventMenus', 'event_id');
    }

    public function eventmenugroup(){
        return $this->hasMany('rijolee\AuthManager\Model\EventMenuUserGroup', 'event_id');
    }

    
	
}
