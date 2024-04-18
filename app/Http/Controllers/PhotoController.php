<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function uploadPhoto(Request $request)
{
     
    if ($request->hasFile('upload')) {
        $photo = $request->file('upload');
        
        // Rename the uploaded file to 'photo'
        $fileName = 'photo.' .time().".". $photo->getClientOriginalExtension();
        
        // Move the uploaded file to the public/blog directory
        $photo->move(public_path('blogs'), $fileName);
        
        // Get the URL of the uploaded image
        $imageUrl = asset('blogs/' . $fileName);
        
        return response()->json([
            'uploaded' => true,
            'url' => $imageUrl,
            'fileName' => $fileName // Include the file name in the response
        ]);
    }
    
    return response()->json(['error' => 'File upload failed.']);
}

    
}
