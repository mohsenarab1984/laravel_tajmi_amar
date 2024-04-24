<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use Inertia\Inertia;

class FileController extends Controller
{

    public  function upload_form()  {
        return Inertia::render('Users/Upload/Index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|mimes:xlsx,docx',
        ], [
            'title.required' => 'The title field is required.',
            'file.required' => 'Please select a file to upload.',
            'file.mimes' => 'The uploaded file must be in xlsx (Excel) or docx (Word) format.',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        
        $user = auth()->user();
        
        // $file->storeAs('public/uploads', $fileName);
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);
        
        $fileEntry = new File();
        $fileEntry->user_id = $user->id;
        $fileEntry->file_name = $fileName;
        $fileEntry->title = $request->title;
        $fileEntry->save();

        return redirect()->back();
        
       // return response()->json(['url' => asset('public/uploads/' . $fileName)]);
    }
}
