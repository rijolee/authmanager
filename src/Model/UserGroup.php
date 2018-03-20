<?php

namespace rijolee\AuthManager\Model;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'usergroups'; 
    
    protected $fillable = [
        'user_id', 'grouproles_id'
    ];


    public function user()
    {
    	return $this->belongsTo('rijolee\AuthManager\Model\Users','user_id');
    }
	
	
}
