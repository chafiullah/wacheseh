<?php
namespace App\Http\Controllers;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
    
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::all();
        return view('role.index',compact('roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions=Permission::all();
       return view('role.create',compact('permissions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $role=Role::create($request->except(['permission','_token']));
        foreach ($request->permission as $key=>$value){
            $role->attachPermission($value);
        }
        return redirect()->route('role.index')->withMessage('role created');
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
        $role=Role::find($id);
        $permissions=Permission::all();
        $role_permissions = $role->perms()->pluck('id','id')->toArray();
         return view('role.edit',compact(['role','role_permissions','permissions']));
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
        $role=Role::find($id);
        $role->name=$request->name;
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        //return $role;
        $role->save();
        $per = DB::table('permission_role')->where('role_id',$id)->delete();
       // $per->delete();
        foreach ($request->permission as $key=>$value){
            $role->attachPermission($value);
        }
        $notification= array('title' => 'Data Store', 'body' => 'Role Updated');
        return redirect()->route('role.index')->with("success",$notification);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return back()->withMessage('Role Deleted');
    }
}