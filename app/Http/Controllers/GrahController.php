<?php

namespace App\Http\Controllers;

use App\Models\Grah;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class GrahController extends Controller
{
    public function index(Request $request){
        try {
             if($request->ajax()){
                $grah = Grah::all();
                
                return DataTables::of($grah)
                ->addIndexColumn()
                ->addColumn('actions',function($g){
                    return '<div class="btn-group">
                    <a href=' . route("grahs.edit", ["grah" => encrypt($g->id)]) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
                    <a onclick="deleteUsers(\'' . $g->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
             }
            return view('admin.grah.index');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create(){
      return view('admin.grah.create');
    }

    public function store(Request $request){
        $request->validate([
           'name' => 'required'
        ]);
        try {
            $grah = Grah::create([
                'name' => $request->name
            ]);

            return redirect()->route('grahs.index')->with('success','Data Saved Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('grahs.index')->with('error','Something went wrong');
        }
    }

    public function edit($id){
        try {
            $id = decrypt($id);
            $grah = grah::find($id);

            return view('admin.grah.edit',compact('grah'));
        } catch (\Throwable $th) {
            return redirect()->route('grahs.index')->with('error','Something went wrong');
        }
    }

    public function update(Request $request){
        $request->validate([
          'name' => 'required',
        ]);
        try {
            $id = decrypt($request->id);
            $grah = Grah::find($id);

            $grah->update([
             'name' => $request->name
            ]);

            return redirect()->route('grahs.index')->with('success','Data Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('grahs.index')->with('error','Something went wrong');
        }
    }
    public function delete(Request $request)
    {
        try {
            $id = $request->grah;
            $intraday = Grah::find($id);
            $intraday->delete();

            return response()->json([
                'success' => 1,
                'message' => "Data deleted Successfully..",
            ]);
        } catch (\Throwable $th) {
         
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
    }
}
