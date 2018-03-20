<?php

namespace App\Http\Controllers;
namespace rijolee\AuthManager\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;


use rijolee\AuthManager\Model\MenuUserGroup;
use rijolee\AuthManager\Model\EventMenuUserGroup;



use rijolee\AuthManager\Model\GroupRoles;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups  = GroupRoles::paginate(10);



        return view('authmanager::permission.show', ['groups' => $groups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_menugroups(Request $request)
    {
        MenuUserGroup::create([
            'grouproles_id' => $request->grouproles_id   
            ,'menu_id' => $request->menu_id
         
            ]);

            $response = ['success'=>'MenuUserGroup successfully Added!!'];

            return response()->json($response);



    }

    public function store_eventmenugroups(Request $request)
    {
        EventMenuUserGroup::create([
            'grouproles_id' => $request->grouproles_id   
            ,'menu_id' => $request->menu_id
            ,'event_id' => $request->event_id
            ]);

            $response = ['success'=>'This Event successfully Added!!'];

            return response()->json($response);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_menugroups($id)
    {
         $response = MenuUserGroup::where('grouproles_id',$id)->orderBy('menu_id')->get();

        
         return response()->json($response);
    }

    public function show($grp_id,$menu_id)
    {   
       // $result = UserGroup::where('grouproles_id',$id)->first()->user->name;

       $result =DB::select( DB::raw(
        "
        SELECT 
            case when c.event_id is null then null else 'Y' end as state
            ,:param1 as grouproles_id
            ,a.menu_id
            ,a.event_id
            ,b.event_nm
             from
            eventmenus a
            inner join
            events b
            on
            a.event_id = b.event_id
            left outer join
            eventmenugroups c
            on a.event_id = c.event_id
            and a.menu_id = c.menu_id
            and c.grouproles_id = :param2
            where
            a.menu_id = :param3
        "
       ), array(
       'param1' => $grp_id
       ,'param2' => $grp_id
       ,'param3' => $menu_id
       
       
        ));

       
       //dd($menu);

        
     //   return view('authmanager::menu', ['menus' => json_encode($menu)
     //     ,'menu_detl' => $menu_detl
        // ]);

       return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_menugroups(Request $request)
    {   
        EventMenuUserGroup::where('grouproles_id',$request->grouproles_id)
            ->where('menu_id',$request->menu_id)
            ->delete();
        
        MenuUserGroup::where('grouproles_id',$request->grouproles_id)
            ->where('menu_id',$request->menu_id)
            ->delete();

        $response = ['success'=>'Menu Group successfully remove!!'];



        
         return response()->json($response);
    }

    public function destroy_eventmenugroups(Request $request)
    {
        
        EventMenuUserGroup::where('grouproles_id',$request->grouproles_id)
            ->where('menu_id',$request->menu_id)
            ->where('event_id',$request->event_id)
            ->delete();

        $response = ['success'=>'This Event successfully remove!!'];



        
         return response()->json($response);
    }
}
