<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function create(Request $request){
        $menus = Menu::all();
        return Inertia::render('Admin/Menu/Create',['menus'=>$menus]);
    }
    public function save(Request $request){
      ////  dd($request->all());
        $validated_data = $request->validate([
            'title'=>['min:3','required'],
            'parent_id'=> ['required'],
            'operation_id'=> ['required'],
        ]);

       /// dd($validated_data);
        $menu = new Menu();
        $menu->title = $validated_data['title'] ;
        $menu->parent_id = $validated_data['parent_id'] ;
        $menu->operation_id = $validated_data['operation_id'] ;
        $menu->save();

       return redirect()->back();

        
    }

    public function update(Request $request, $id){
        // dd('!!',$request->all());
        $menu = Menu::find($id);
        $menu->title = $request->title;
        $menu->save();

        return redirect()->back() ;

    }

    public function destroy(Request $request ) {
        $menu= Menu::findOrfail($request->id);
        $menu->delete();
        return back();
    }
}
