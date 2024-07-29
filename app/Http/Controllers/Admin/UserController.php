<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileRequest;

use App\Http\Requests\UserRequest;

use App\Models\User;
use App\Traits\ImageTrait;
use Auth;
use DB;use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:users|users.create|users.edit|users.destroy', ['only' => ['index', 'store']]);
        $this->middleware('permission:users.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);

    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Amenities
            $users = User::get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $default_image = asset("public/images/uploads/user_images/no-image.png");
                    $image = ($row->image) ? asset('public/images/uploads/user_images/' . $row->image) : $default_image;
                    $image_html = '';
                    $image_html .= '<img class="me-2" src="' . $image . '" width="50" height="50">';
                    return $image_html;
                })
                ->addColumn('usertype', function ($row) {
                    $usertype = $row->role_id;
                    $role = Role::where('id', $usertype)->first();
                    return $role->name;
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    $checked = ($status == 1) ? 'checked' : '';
                    $checkVal = ($status == 1) ? 0 : 1;
                    $user_id = isset($row->id) ? $row->id : '';
                    if ($user_id != 1) {
                        return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus(' . $checkVal . ',' . $user_id . ')" id="statusBtn" ' . $checked . '></div>';
                    }
                })
                ->addColumn('actions', function ($row) {
                    $user_id = isset($row->id) ? $row->id : '';
                    $action_html = '';
                    $action_html .= '<a href="' . route('users.edit', encrypt($user_id)) . '" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';

                    if ($user_id != 1) {
                        $action_html .= '<a onclick="deleteUsers(\'' . encrypt($user_id) . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';

                    }

                    return $action_html;
                })
                ->rawColumns(['status', 'usertype', 'actions', 'image'])
                ->make(true);
        }
        return view('admin.users.list');
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {

        try {
            $input = $request->except('_token', 'image', 'confirm_password', 'password');
            $input['password'] = Hash::make($request->password);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $image_url = $this->addSingleImage('user', 'user_images', $file, $old_image = '');
                $input['image'] = $image_url;
            }

            $user = User::create($input);
            $role_id = $user->role_id;

            $roles = Role::where('id', $role_id)->first();
            $user->assignRole($roles->name);

            return redirect()->route('users')->with('message', 'User created successfully');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('users')->with('error', 'Something with wrong');

        }
    }

    // Store a Users status Changes resource in storage..
    public function status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        try {
            $input = User::find($id);
            $input->status = $status;
            $input->update();

            return response()->json([
                'success' => 1,
                'message' => "User Status has been Changed Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $id = decrypt($id);
        $data = User::where('id', $id)->first();
        $roles = Role::all();
        return view('admin.users.edit', compact('data', 'roles'));
    }

    public function update(UserRequest $request)
    {
        try {
            $input = $request->except('_token', 'id', 'password', 'confirm_password', 'image');
            $id = decrypt($request->id);

            if (!empty($request->password) || $request->password != null) {
                $input['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $img = User::where('id', $id)->first();
                $old_image = $img->image;
                $file = $request->file('image');
                $image_url = $this->addSingleImage('user', 'user_images', $file, $old_image = '');
                $input['image'] = $image_url;
            }
            $user = User::find($id);
            $user->update($input);
            DB::connection('mysql')->table('model_has_roles')->where('model_id', $id)->delete();
            $role_id = $user->role_id;
            $roles = Role::where('id', $role_id)->first();
            $user->assignRole($roles->name);

            return redirect()->route('users')->with('message', 'User updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error', 'Something with wrong');
        }
    }

    public function destroy(Request $request)
    {
        try {
            //code...
            $id = decrypt($request->id);

            $user = User::where('id', $id)->first();

            $img = isset($user->image) ? $user->image : '';

            if (!empty($img) && file_exists('public/images/uploads/user_images/' . $img)) {
                unlink('public/images/uploads/user_images/' . $img);
            }

            User::where('id', $id)->delete();
            return response()->json([
                'success' => 1,
                'message' => "User delete Successfully..",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }

    public function profileEdit($id)
    {
        $data = User::where('id', $id)->first();
        $roles = Role::where('id', $data->role_id)->first();
        return view('admin.profile.edit', compact('data', 'roles'));

    }

    public function profileUpdate(ProfileRequest $request)
    {
        try {
            $input = $request->except('_token', 'id', 'password', 'confirm_password', 'image');
            $id = $request->id;

            if (!empty($request->password) || $request->password != null) {
                $input['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $img = User::where('id', $id)->first();
                $old_image = $img->image;
                $file = $request->file('image');
                $image_url = $this->addSingleImage('user', 'user_images', $file, $old_image = '');
                $input['image'] = $image_url;
            }
            $user = User::find($id);
            $user->update($input);
            DB::connection('mysql')->table('model_has_roles')->where('model_id', $id)->delete();
            $role_id = $user->role_id;
            $roles = Role::where('id', $role_id)->first();
            $user->assignRole($roles->name);

            return redirect()->route('profile.edit', Auth::user()->id)->with('message', 'Profile updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error', 'Something with wrong');
        }
    }

    public function settingDetail(Request $request){
        if ($request->ajax()) {
            // Get all Amenities
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Since DataTables expects a collection, we wrap the user in a collection
            $users = collect([$user]);

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $user_id = isset($row->id) ? $row->id : '';
                    $action_html = '';
                    $action_html .= '<a href="' . route('settingEdit', encrypt($user_id)) . '" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                    return $action_html;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.users.settingList');
    }

    public function settingEdit($id){

        $id = decrypt($id);
        try {
            $userData = User::find($id);

            return view('admin.users.settingListEdit',compact('userData'));

        } catch (\Throwable $th) {
            return redirect()->route('settingDetail')->with('error', 'Something with wrong');
        }
    }

    public function settingUpdate(Request $request){
        $request->validate([
            'username' => 'required',
            'api_key' => 'required',
            't_otp' => 'required',
            'setting_password' => 'required',
         ], [
            'api_key.required' => 'The Api Key field is required.',
            't_otp.required' => 'The t otp field is required.',
            'setting_password.required' => 'The password field is required.',
        ]);

         
        $id = decrypt($request->id);
        
        try {
           
            $userData = User::find($id);

            $userData->update([
              'username' => $request->username,
              'api_key' => $request->api_key,
              't_otp' => $request->t_otp,
              'setting_password' => $request->setting_password,
            ]);

      return redirect()->route('settingDetail')->with('message','Data updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('settingDetail')->with('error','Something went wrong');
        }
    }

}
