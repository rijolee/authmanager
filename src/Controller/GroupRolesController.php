<?php

namespace rijolee\AuthManager\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use rijolee\AuthManager\Model\Users;
use rijolee\AuthManager\Model\UserGroup;



use rijolee\AuthManager\Model\GroupRoles;
use Illuminate\Support\Facades\DB;



class GroupRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $groups  = GroupRoles::paginate(10);
        $users  = Users::all();



        return view('authmanager::group.show', ['groups' => $groups
            ,'users' => $users
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
                    select concat('G',coalesce(max(cast(substring(grouproles_id,2) as UNSIGNED)),0)+1) as new_id from grouproles
                    "
                   ));
                
        GroupRoles::create([
            'grouproles_id' => $new_id[0]->new_id   
            ,'grouproles_nm' => $request->grouproles_nm
           ,'grouproles_desc' => $request->grouproles_desc
         
        ]);

         Session::flash('success','GroupRoles successfully added') ;


         return response()->json($request);       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    

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
        $e = GroupRoles::where('grouproles_id',$request->grouproles_id)->first();

                if(!is_null($request->grouproles_nm )){
                    $e->grouproles_nm = $request->grouproles_nm;
                }
                if(!is_null($request->grouproles_desc )){
                    $e->grouproles_desc = $request->grouproles_desc;
                }
            
        $e->save();
        Session::flash('success','GroupRoles successfully updated') ;

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
        //GroupRoles::destroy($request->grouproles_id);

        GroupRoles::where('grouproles_id',$request->grouproles_id)->first()->eventmenugroup()->delete();
        GroupRoles::where('grouproles_id',$request->grouproles_id)->first()->usergroup()->delete();
        GroupRoles::where('grouproles_id',$request->grouproles_id)->delete();
        

        Session::flash('success','GroupRoles successfully removed. And related table also!') ;


         return response()->json($request);
    }

    public function action(Request $request)
    {


        

        


        if ($request->action == 'edit') {
            if(!is_null($request->grouproles_id ))
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
