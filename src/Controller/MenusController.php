<?php

namespace rijolee\AuthManager\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use rijolee\AuthManager\Model\Menus;
use rijolee\AuthManager\Model\EventMenus;

use Illuminate\Support\Facades\DB;





class MenusController extends Controller
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
        //$menu_id = Menus::all()->max('menu_id')+1;
        $new_id = DB::select( DB::raw(
        "
        select concat('M',coalesce(max(cast(substring(menu_id,2) as UNSIGNED)),0)+1) as new_id from menus
        "
       ));

       
        
        

        Menus::create([
            'menu_id' => $new_id[0]->new_id,
            'parent_id' => $request->parent_id,
            'menu_order' => $request->menu,
            'menu_nm' => $request->menu_nm,
            'menu_order' => $request->menu_order,
            'system_nm' => $request->system_nm,
            'url' => $request->url,
            'desc' => $request->desc,
            'class' => $request->class,
            
            

        ]);

         Session::flash('success','Menu successfully added') ;



        return redirect()->route('authmanager.load',['system' => $request->system_nm]);



    }

    public function storebelow(Request $request,$parentid)
    {   
        //$menu_id = Menus::all()->max('menu_id')+1;
        $new_id = DB::select( DB::raw(
        "
        select concat('M',coalesce(max(cast(substring(menu_id,2) as UNSIGNED)),0)+1) as new_id from menus
        "
       ));

       
        

        Menus::create([
            'menu_id' => $new_id[0]->new_id,
            'parent_id' => $request->$parentid,
            'menu_order' => $request->menu,
            'menu_nm' => $request->menu_nm,
            'menu_order' => $request->menu_order,
            'system_nm' => $request->system_nm,
            'url' => $request->url,
            'disp_yn' => $request->disp_yn,
            'desc' => $request->desc,
            'class' => $request->class,

            
            
            
            

        ]);

         Session::flash('success','Menu successfully added') ;



        return redirect()->route('authmanager.load',['system' => $request->system_nm]);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update()
    {
        $r = request();

        $this->validate($r,[
            'menu_nm' => 'required'
            ,'system_nm' => 'required'
            ,'menu_order' => 'required'



        ]);

        $m = Menus::where('menu_id',$r->menu_id)->first();

        $m->menu_nm = $r->menu_nm;
        $m->menu_order = $r->menu_order;
        $m->system_nm = $r->system_nm;
        $m->url = $r->url;
        $m->disp_yn = $r->disp_yn;
        


        $m->save();


        Session::flash('success','Menu successfully updated') ;

        //dd(Session::all());


        //return redirect()->route('authmanager.load',['system' => $r->system_nm]);
        return redirect()->back();
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        

        $m = Menus::where('menu_id',$request->menu_id)->first();
        
        $system_nm = $m->system_nm;

        // Menus::where('menu_id',$request->menu_id)->first()->eventmenugroup()->delete();
        // Menus::where('menu_id',$request->menu_id)->first()->eventmenus()->delete();
        $m->eventmenugroup()->delete();
        $m->eventmenus()->delete();
        $m->delete();

        // Session::flash('success','Menu successfully removed. And related table also!') ;

        //dd(Session::all());


        // return redirect()->route('authmanager.load',['system' => $system_nm]);

        $response = ['success'=>'Menu successfully remove!!'];
        return response()->json($response);



    }

    

    public function trees($id)
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
       'param1' => $id
       ,'param2' => $id
       
        ));


       return response()->json($menu); 




    }

    public function getmenu($id)
    {
        
       $menu = DB::select( DB::raw(
        "
        SELECT 
        *
        FROM menus WHERE 'all' = :param1  OR system_nm = :param2 
        order by menu_order 
        "
       ), array(
       'param1' => $id
       ,'param2' => $id
       
        ));


       return response()->json($menu); 




    }

    
}
