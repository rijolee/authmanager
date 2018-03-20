<?php

namespace rijolee\AuthManager\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use rijolee\AuthManager\Model\Events;
use Illuminate\Support\Facades\DB;



class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        return view('authmanager::events.show', ['events' => Events::paginate(10)
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
    public function store(Request $request)
    {
        $new_id = DB::select( DB::raw(
                    "
                    select concat('E',coalesce(max(cast(substring(event_id,2) as UNSIGNED)),0)+1) as new_id from events
                    "
                   ));
                
                Events::create([
                    'event_id' => $new_id[0]->new_id   
                    ,'event_nm' => $request->event_nm
                   ,'event_desc' => $request->event_desc
                 
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
    public function update(Request $request)
    {
        $e = Events::where('event_id',$request->event_id)->first();

                if(!is_null($request->event_nm )){
                    $e->event_nm = $request->event_nm;
                }
                if(!is_null($request->event_desc )){
                    $e->event_desc = $request->event_desc;
                }
            
        $e->save();
        Session::flash('success','Events successfully updated') ;

         return response()->json($request);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        //Events::destroy($request->event_id);

        Events::where('event_id',$request->event_id)->first()->eventmenugroup()->delete();
        Events::where('event_id',$request->event_id)->first()->eventmenus()->delete();
        Events::where('event_id',$request->event_id)->delete();
        

        Session::flash('success','Events successfully removed. And related table also!') ;


         return response()->json($request);
    }

    public function action(Request $request)
    {


        

        


        if ($request->action == 'edit') {
            if(!is_null($request->event_id ))
            {
                return $this->update($request);
            }
            else
            {   
                return $this->store($request);
            }   
                
        }

        if ($request->action == 'delete') {
    
            return $this->destroy($request);
                
        }

        

        return response()->json($request);
        # code...
        //$data = User::take(5)->get();
        //dd($data);
 
        //return view('tabledit',['users'=>$data]);

    }
}
