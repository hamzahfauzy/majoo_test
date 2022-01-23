<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    //
    function upload(Request $request)
    {
        $request->validate([
			'files.*' => 'required',
		]);

        $files  = $request->file('files');
        // return $files;
        $images = [];
        foreach($files as $file)
        {
            $url = $file->store('images');
            $images[] = Image::create([
                'name' => $file->getClientOriginalName(),
                'file_url'  => \Storage::url($url)
            ]);
        }

        return response()->json($images, 200);
    }
}
