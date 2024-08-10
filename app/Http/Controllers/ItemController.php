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

    public function update_adder(Request $request,  $id){
        $type = $request->type;
        $data = [] ;
        $validator_rule=[];

        $item = Item::findOrFail($id);

        // dd($request->all());

        if($type=='number'){
                $data['input_value_new']= $request->input('input_value_new') ;

                $validator_rule['input_value_new'] = ['required','numeric'];
                if ($item->min) {  $validator_rule['input_value_new'][] = 'min:'.$item->min;    }  
                if ($item->max) {   $validator_rule['input_value_new'][] = 'max:'.$item->max;  }  

                $message = [
                    'input_value_new.required' => 'انتخاب فیلد مقدار ضروری است ',  
                    'input_value_new.numeric' => '  فیلد مقدار باید عددی باشد ',   
                    'input_value_new.min' => 'حداقل مقدار مجاز برابر است با :  ' . $item->min . '.',  
                    'input_value_new.max' => 'حداکثر مقدار مجاز برابر است با :  ' . $item->max . '.', 
                 ] ;
        }else{
                $data['input_ticket_new']=  $request->input('input_ticket_new') ;
                $validator_rule['input_ticket_new'] = ['required'];
                $message = [
                    'input_ticket_new.required' => 'انتخاب فیلد نوع ضروری است ',  
                ] ;
        }

         //dd($data);
          
         $data['related_date'] = $request->input('date_en') ?? null  ;
         $data['added_at'] = now()  ;
        
       
          $request->validate($validator_rule, $message) ;
         $data['change'] = 1;
         $data['accept'] = NULL;

         
         $item->update($data) ;

        
         return redirect()->back();
        //  $new_data =  $item-
        //  $item->update(['']);
    }
    public function update_verifier(Request $request, $id){
        $item = Item::findOrFail($id);
        $validated_data = $request->validate([
            'accept'=>['required']
        ]);
        $validated_data['change']=0;
        if($item->type  == 'number') { 
             $validated_data['input_value']=$item->input_value_new ;
         }
        else {
            $validated_data['input_ticket']=$item->input_ticket_new ;
        } 
       
        $item->update($validated_data);

         /// Append history
        $item = $item->fresh(); /// get new updated row

        $existingHistory = $item->history; // Assuming the history field exists  
        $historyField = json_decode($existingHistory, true) ?? []; // Decode existing history  

       // Step 4: Add the current item's data to the history array  
       $historyField[] = $item->toArray(); // Save the current item (as an array)  

       // Step 5: Encode the updated history  
       $historyFieldEncoded = json_encode($historyField);  

       // Step 6: Update the item's history field  
       $item->update(['history' => $historyFieldEncoded]);    




        return back() ;
    }

    public function save(Request $request){
       // dd($request->all());
          $validated_data = $request->validate([
              'title'=>['min:3','required'],
              'type'=> ['required'],
              'menu_id'=> ['required'],
              'adder_id'=> ['required'],
              'verifier_id'=> ['required'],
              'viewer_id'=> ['required'],
              'viewer_arr'=> ['required','array'],
              'viewer_arr.*' => 'exists:users,id',
              'min'=> [],
              'max'=> [],
              //'date_en'=> [],
          ]);
  
          //dd($validated_data);
          $item = new Item();
          $item->title = $validated_data['title'] ;
          $item->type = $validated_data['type'] ;
          $item->menu_id = $validated_data['menu_id'] ;
          $item->adder_id = $validated_data['adder_id'] ;
          $item->verifier_id = $validated_data['verifier_id'] ;
          $item->viewer_id = $validated_data['viewer_id'] ;
          $item->min = $validated_data['min'] ;
          $item->max = $validated_data['max'] ;
          //$item->related_date = $validated_data['date_en']  ;
          //$item->added_at = now()  ;
          
          $item->save();
          $item->viewers()->sync($validated_data['viewer_arr']);

  
         return redirect()->back();
  
          
      }
}
