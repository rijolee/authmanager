<?php

namespace rijolee\AuthManager\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use rijolee\AuthManager\Model\Menus;
use rijolee\AuthManager\Model\EventMenus;
use rijolee\AuthManager\Model\EventMenuUserGroup;


use Illuminate\Support\Facades\DB;


class EventMenusController extends Controller
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
    public function store(Request $request, $menu_id)
    {
       
                
                EventMenus::create([
                    'event_id' => $request->event_id
                   ,'menu_id' => $menu_id
                 
                ]);

         Session::flash('success','Events successfully added') ;


         return response()->json($request);       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($menu_id)
    {   
       //$em = EventMenus::where('menu_id',$menu_id)->get();
       $em = DB::select( DB::raw(
        "
        SELECT 
        a.menu_id
        , b.menu_nm
        , a.event_id
        , c.event_nm
        FROM eventmenus a, menus b, events c 
        WHERE a.event_id = c.event_id
        and a.menu_id = b.menu_id
        and a.menu_id = :param1
        order by a.event_id 
        "
       ), array(
     'param1' => $menu_id
     
    ));


        
       return response()->json($em);

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
    public function update(Request $request,$oldmenu,$oldevent)
    {

                if(!is_null($request->event_id )){
                    // $e = EventMenus::where('menu_id',$oldmenu)->where('event_id',$oldevent)->first();
                    // $e->event_id = $request->event_id;
                    //$e->save();


                    DB::table('eventmenus')
                            ->where('menu_id',$oldmenu)
                            ->where('event_id',$oldevent)
                            ->update(['event_id' => $request->event_id]);

                }
                
            
        
        Session::flash('success','Menu - Events successfully updated') ;

         return response()->json($request);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$oldmenu,$oldevent)
    {
        //EventMenus::destroy($request->event_id);
        EventMenuUserGroup::where('menu_id',$oldmenu)->where('event_id',$oldevent)->delete();
        
        EventMenus::where('menu_id',$oldmenu)->where('event_id',$oldevent)->delete();




        Session::flash('success','Menu - Events successfully removed') ;


        return response()->json($request);
    }

    public function action(Request $request)
    {

        //$request = request();

        $arr = explode(".",$request->row_id);
        $oldmenu = $arr[0];
        $oldevent = $arr[1];


        if ($request->action == 'edit') {
            if($oldevent == 'new')
            {
                return $this->store($request, $oldmenu);
            }
            else
            {   
                return $this->update($request,$oldmenu,$oldevent);
                
            }   
                
        }

        if ($request->action == 'delete') {
    
            return $this->destroy($request,$oldmenu,$oldevent);
                
        }

        

        return response()->json($request);
        # code...
        //$data = User::take(5)->get();
        //dd($data);
 
        //return view('tabledit',['users'=>$data]);

    }
}
