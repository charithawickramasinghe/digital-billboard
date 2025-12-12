<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class BillboardController extends Controller
{
    public function show($screen_id)
    {
        $images = Image::where('screen_id', $screen_id)->get();

        return view('billboard', compact('images'));
    }
}
