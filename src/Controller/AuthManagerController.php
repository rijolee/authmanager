<?php

namespace rijolee\AuthManager\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use rijolee\AuthManager\Model\Menus;
use rijolee\AuthManager\Model\EventMenus;
use rijolee\AuthManager\Model\Events;


use Illuminate\Support\Facades\DB;

use Session;


class AuthManagerController extends Controller
{
    public function index()
    {   
       

       $menu = [];

       //dd($menu);

        
       return view('authmanager::index', ['menus' => json_encode($menu)
       	]);
    }

    public function create()
    {   
       

       $menu = [];

       //dd($menu);

        
       return view('authmanager::menu.create', ['menus' => json_encode($menu)
       	]);
    }



    public function createbelow($parentid,$system_nm)
    {   
       

       $menu = DB::select( DB::raw(
       	"
       	SELECT 
        menu_id as id
        ,case when parent_id = '' then '#' else parent_id end as parent	
        ,menu_nm as text 
       	FROM menus WHERE 'all' = :param1  OR system_nm = :param2 
       	order by menu_order 
       	"
       ), array(
	   'param1' => $system_nm
	   ,'param2' => $system_nm
	   
	 	));

       //dd($menu);


        
       return view('authmanager::menu.createbelow', ['menus' => json_encode($menu)
        ,'parentid' => $parentid
       	]);
    }

    public function load($system_nm)
    {   
       
       //$system_nm = request()->system;



       $menu = DB::select( DB::raw(
       	"
       	SELECT 
        menu_id as id
        ,case when parent_id = '' then '#' else parent_id end as parent	
        ,menu_nm as text 
       	FROM menus WHERE 'all' = :param1  OR system_nm = :param2 
       	order by menu_order 
       	"
       ), array(
	   'param1' => $system_nm
	   ,'param2' => $system_nm
	   
	 	));

       //dd($menu);

       $event = DB::select( DB::raw(
        "
        SELECT 
        event_id 
        ,event_nm
        FROM events 
        order by event_id 
        "
       ));


        
       return view('authmanager::show', ['menus' => json_encode($menu)
       	,'events' => json_encode($event)
        ,'system' => $system_nm
       	]);
    }



    public function menu($id)
    {   
       $menu_detl = Menus::find($id);

       
       //dd($menu);

        
     //   return view('authmanager::menu', ['menus' => json_encode($menu)
     //   	,'menu_detl' => $menu_detl
   		// ]);

       return response()->json($menu_detl);
    }

    public function showmenu($id,$system_nm)
    {   
       $menu_detl = Menus::find($id);

       //$system_nm = 'FI';

       $menu = DB::select( DB::raw(
        "
        SELECT 
        menu_id as id
        ,case when parent_id = '' then '#' else parent_id end as parent 
        ,menu_nm as text 
        FROM menus WHERE 'all' = :param1  OR system_nm = :param2 
        order by menu_order 
        "
       ), array(
     'param1' => $system_nm
     ,'param2' => $system_nm
     
    ));

       $event = DB::select( DB::raw(
        "
        SELECT 
        event_id 
        ,event_nm
        FROM events 
        order by event_id 
        "
       ));

       //dd($menu);

        
       return view('authmanager::menu.menu', ['menus' => json_encode($menu)
       	,'events' => json_encode($event)
        ,'menu_detl' => $menu_detl
   		]);

    }

    public function menu_update()
    {
        $r = request();

        $this->validate($r,[
            'menu_nm' => 'required'
			,'system_nm' => 'required'
			,'menu_order' => 'required'



        ]);

        $m = Menus::find($r->menu_id);

        $m->menu_nm = $r->menu_nm;
        $m->menu_order = $r->menu_order;
        $m->system_nm = $r->system_nm;
        $m->url = $r->url;

        $m->save();


        Session::flash('success','Menu successfully updated') ;

        //dd(Session::all());


        return redirect()->back();


    }





}
