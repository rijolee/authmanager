<?php

namespace rijolee\AuthManager\Model;

use Illuminate\Database\Eloquent\Model;

class EventMenuUserGroup extends Model
{
    protected $table = 'eventmenugroups'; 
    protected $fillable = [
        'event_id', 'menu_id','grouproles_id'
    ];
	

    public function event()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\Events');
    }

    public function menu()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\Menus');
    }

    public function group()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\GroupRoles');
    }
}
