<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Operation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OperationController extends Controller
{

    public function show($id){
         $operation = Operation::find($id) ;
         $menus = Menu::where('operation_id',$id)->OrderBy('id')->with('items.adder','items.verifier','items.viewer')->get();
         return Inertia::render('Admin/Operation/Edit',['operation'=>$operation,'menus'=>$menus]);
    }

    public function save_title(Request $request){
        $validated_data = $request->validate([
            'title'=>['min:3','required'],
            
        ]);
        $operation = new Operation() ;
        $operation->title = $validated_data['title'] ;
        $operation->save();

        $operationId = $operation->id;

        //return back()->with('operationId', $operationId);

        //return Inertia::location(route('admin.operation.save_title'), ['operationId' => $operationId]);

        return redirect()->route('operation.show',$operationId);



        //return response()->json(['id' => $operationId, 'message' => 'Operation created successfully']);
    }

    public function index(){
        $operations = Operation::all() ;
        return Inertia::render('Admin/Operation/Index',['operations'=>$operations]) ;
    }
}
