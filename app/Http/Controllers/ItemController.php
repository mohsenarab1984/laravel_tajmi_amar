<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ItemController extends Controller
{

    public function index(Request $request){
        $user_id = auth()->user()->id ;
        $all_items = Item::adderVerifierViewer()->where('adder_id',$user_id)->orWhere('verifier_id',$user_id)->orWhere('viewer_id',$user_id)->get();
       // dd($all_items,$user_id);
        return Inertia::render('Admin/Report/Index',['items'=>$all_items,'user_id'=>$user_id]);
    }

    public function update(Request $request,  $id){
        $type = $request->type;
        $data = [] ;
        if($type=='number'){
           $data['input_value_new']= $request->input('input_value_new') ;
        }else{
           $data['input_ticket_new']= $request->input('input_ticket_new') ;
        }
         //dd($request->all(), $id);

         $item = Item::findOrFail($id);

         $validator_rule['input_value_new'] = ['required','numeric'];
         // Or you could use bracket notation for a more concise syntax:  
        if ($item->min) {  
            $validator_rule['input_value_new'][] = 'min:'.$item->min;  
        }  

        if ($item->max) {  
            $validator_rule['input_value_new'][] = 'max:'.$item->max;  
        }  
         
          
         // print_r($validator_rule);

          //dd();
          
          $request->validate($validator_rule, [  
            'input_value_new.required' => 'The number field is mandatory.',  
            'input_value_new.numeric' => 'The input must be a valid number.',  
            'input_value_new.min' => 'The number must be at least ' . $item->min . '.',  
            'input_value_new.max' => 'The number may not be greater than ' . $item->max . '.',  
        ]) ;

         $item->update($data) ;
         return redirect()->back();
        //  $new_data =  $item-
        //  $item->update(['']);
    }

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
          $item->min = $validated_data['min'] ;
          $item->max = $validated_data['max'] ;
        
          $item->save();
  
         return redirect()->back();
  
          
      }
}
