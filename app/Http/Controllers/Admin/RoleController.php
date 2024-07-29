<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\{User, RoleHasPermissions};


class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:roles|roles.create|roles.edit|roles.destroy', ['only' => ['index','show']]);
         $this->middleware('permission:roles.create', ['only' => ['create','store']]);
         $this->middleware('permission:roles.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:roles.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $roles= Role::get();
            return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('actions',function($row)
            {
                $role_id = isset($row->id) ? encrypt($row->id) : '';
                $action_html = '';
                $action_html .= '<a href="'.route('roles.edit',$role_id).'" class="btn btn-sm custom-btn me-1 "><i class="bi bi-pencil"></i></a>';
                $action_html .= '<a  onclick="deleteRole(\''.$role_id.'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                return $action_html;
            })
            ->rawColumns(['actions'])
            ->make(true);
        }
        return view('admin.roles.list');
    }

    public function create(){

        $permission = Permission::get();

        return view('admin.roles.create',compact('permission'));
    }

    public function store(Request $request)
    {
        try {

            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            return redirect()->route('roles')
                        ->with('message','Role created successfully');
        } catch (\Throwable $th) {
        return redirect()->route('roles')->with('error','Something went wrong');
        }
    }

    public function edit(Request $request, $id)
    {
        $id = decrypt($id);
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::connection('mysql')->table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit',compact('role','permission','rolePermissions'));
    }


    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);


        $id = decrypt($request->id);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles')
                        ->with('message','Role updated successfully');
    }

    public function destroy(Request $request)
    {
        try
        {
            $id = decrypt($request->id);
            $role = Role::where('id',$id)->delete();


            return response()->json(
            [
                'success' => 1,
                'message' => "Role delete Successfully..",
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json(
            [
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }
}
