<?php

namespace rijolee\AuthManager\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use rijolee\AuthManager\Model\UserGroup;

use Illuminate\Support\Facades\DB;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {   

        $cnt = UserGroup::where('user_id',$request->user_id)->where('grouproles_id',$request->grouproles_id )->count();

        if($cnt > 0){
            $response = ['error'=>'User Already Exist!!'];

        }
        else{
            UserGroup::create([
            'grouproles_id' => $request->grouproles_id   
            ,'user_id' => $request->user_id
         
            ]);

            $response = ['success'=>'User successfully Added!!'];




        }


        



         //Session::flash('success','GroupRoles successfully added') ;



         return response()->json($response);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
       // $result = UserGroup::where('grouproles_id',$id)->first()->user->name;

       $result =DB::select( DB::raw(
        "
        SELECT 
        b.user_id
        , a.grouproles_id
        , b.name
        , b.email
        FROM usergroups a, users b 
        WHERE 
        a.user_id = b.user_id
        and a.grouproles_id = :param1
        "
       ), array(
       'param1' => $id
       
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
    public function destroy(Request $request)
    {
        
        UserGroup::where('grouproles_id',$request->grouproles_id)->where('user_id',$request->user_id)->delete();

        $response = ['success'=>'User successfully remove!!'];



        
         return response()->json($response);
    }
}
