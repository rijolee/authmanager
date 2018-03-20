<?php

namespace rijolee\AuthManager\Model;

use Illuminate\Database\Eloquent\Model;

class EventMenus extends Model
{
    protected $table = 'eventmenus'; 
    protected $fillable = [
        'event_id', 'menu_id'
    ];
	

    public function event()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\Events','event_id');
    }

    public function menu()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\Menus','menu_id');
    }

}
