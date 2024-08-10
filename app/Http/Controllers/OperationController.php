<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Operation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OperationController extends Controller
{

    public function show($id){
         $operation = Operation::findorFail($id) ;
         $menus = Menu::where('operation_id',$id)->OrderBy('id')->with('items.adder','items.verifier','items.viewer','items.viewers')->get();
       
        /// $item = Item::where('id',19)->with('viewers')->get();
        // //dd($item);

         
         ////return Inertia::render('Admin/Operation/Edit',['operation'=>$operation,'menus'=>$menus]);



        $user_id = auth()->user()->id;  
        $operation = Operation::find($id);  

        $user_id = auth()->user()->id; 
        if(auth()->user()->is_admin == 1){

            $menus = Menu::where('menus.operation_id', $id)  
                ->with(['items.adder','items.verifier','items.viewers'])  
                ->orderBy('menus.id')  
                ->get(); 
                
                //dd(['operation' => $operation, 'menus' => $menus]);

        } else{
            $menus = Menu::where('menus.operation_id', $id)  
                ->with(['items' => function($query) use ($user_id) {  
                    $query->where(function($query) use ($user_id) {  
                        $query->where('items.adder_id', $user_id)  
                              ->orWhere('items.verifier_id', $user_id);  
                    })  
                    ->orWhereHas('viewers', function ($query) use ($user_id) {  
                        $query->where('viewer_id', $user_id); // This checks if the viewer_id matches the current user id  
                    })  
                    ->with(['adder', 'verifier', 'viewers']);  
                }])  
                ->orderBy('menus.id')  
                ->get()  
                ->toArray();
        }

           //dd(Menu::with('items')->get()->toArray());

         
        //dd($menus);

    return Inertia::render('Admin/Operation/Edit', ['operation' => $operation, 'menus' => $menus]); 
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
