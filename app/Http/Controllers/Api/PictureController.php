<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Intervention\Image\Facades\Image as Image;

class PictureController extends Controller
{
    public function show(Request $request)
    {
        /*
        $contents = Storage::get($request->pic_url);
        $file_extension = strtolower(substr(strrchr($request->pic_url,"."),1));
        
        // dd($request, $file_extension, $contents);
        
        switch( $file_extension ) {
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg": $ctype="image/jpeg"; break;
            case "jpg": $ctype="image/jpeg"; break;
            default:
        }
        ob_clean();
        header("Content-type: " . $ctype);
        $response = Image::make($contents)->response($ctype);
        return $response;
        */
        
        if(!Storage::exists($request->pic_url)) {
            return Response::make('File no found',404);
        }
        
        $file = Storage::get($request->pic_url);
        $type = Storage::mimeType($request->pic_url);
        $response = Response::make($file, 200)->header("Content-Type",$type);
        
        return $response;
    }
}
