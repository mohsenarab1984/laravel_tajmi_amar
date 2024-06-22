<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function create(Request $request){
        return Inertia::render('Admin/Menu/Create');
    }
    public function save(Request $request){
        $validated_data = $request->validate([
            'title'=>['min:3','required'],
            'parent_id'=> ['required']
        ]);
        $menu = new Menu();
        $menu->title = $validated_data['title'] ;
        $menu->parent_id = $validated_data['parent_id'] ;
        $menu->save();

       return redirect()->back();

        
    }
}
