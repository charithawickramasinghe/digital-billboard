<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuCardController extends Controller
{
    public function index()
    {
        return view('menucard');
    }


    // Save base64 image sent from client
    public function save(Request $request)
    {
        $data = $request->input('image'); // data:image/jpeg;base64,....
        if (! $data) {
            return response()->json(['error' => 'No image data'], 400);
        }


        // parse base64
        if (preg_match('/^data:(image\/[a-zA-Z]+);base64,/', $data, $m)) {
            $mime = $m[1];
            $data = substr($data, strpos($data, ',') + 1);
            $data = base64_decode($data);


            if ($data === false) {
                return response()->json(['error' => 'Base64 decode failed'], 400);
            }


            // choose extension by mime
            $ext = explode('/', $mime)[1];
            if ($ext === 'jpeg') $ext = 'jpg';
            $filename = 'menucard_' . Str::random(10) . '.' . $ext;


            $path = 'public/menucards/' . $filename;
            Storage::put($path, $data);


            $url = Storage::url('menucards/' . $filename); // will return /storage/menucards/...


            return response()->json(['url' => $url], 200);
        }


        return response()->json(['error' => 'Invalid data URI'], 400);
    }
}