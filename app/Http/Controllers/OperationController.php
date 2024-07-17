<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OperationController extends Controller
{
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

        return redirect()->route('admin.operation.edit',$operationId);



        //return response()->json(['id' => $operationId, 'message' => 'Operation created successfully']);
    }
}
