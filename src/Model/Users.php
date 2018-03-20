<?php

namespace rijolee\AuthManager\Model;

use App\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends User
{
    use Notifiable;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function group()
    {
    	//return $this->hasMany('rijolee\AuthManager\Model\UserGroup','user_id');
        return $this->belongsToMany('rijolee\AuthManager\Model\GroupRoles', 'usergroups','user_id','grouproles_id');
    }

    public function hasEvents($event_id, $menu_id){
    	//$user = rijolee\AuthManager\Model\Users::find(1)

        $gr = $this->first()->group->first();

        $m = $gr -> hasmenus()->wherePivot('event_id',$event_id)->wherePivot('menu_id',$menu_id)->count();

    	
    	if($m > 0 ) 
    		{
    			return true;
    		}	

    	else{
    		return false;
    		}


    	


	}

}
