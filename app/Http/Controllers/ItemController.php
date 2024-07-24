<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function save(Request $request){
        ////  dd($request->all());
          $validated_data = $request->validate([
              'title'=>['min:3','required'],
              'type'=> ['required'],
              'menu_id'=> ['required'],
              'adder_id'=> ['required'],
              'verifier_id'=> ['required'],
              'viewer_id'=> ['required'],
              'min'=> [],
              'max'=> [],
          ]);
  
         /// dd($validated_data);
          $item = new Item();
          $item->title = $validated_data['title'] ;
          $item->type = $validated_data['type'] ;
          $item->menu_id = $validated_data['menu_id'] ;
          $item->adder_id = $validated_data['adder_id'] ;
          $item->verifier_id = $validated_data['verifier_id'] ;
          $item->viewer_id = $validated_data['viewer_id'] ;
        
          $item->save();
  
         return redirect()->back();
  
          
      }
}
