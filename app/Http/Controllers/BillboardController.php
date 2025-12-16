<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class BillboardController extends Controller
{
    public function show($screen_id)
    {
        $userId = Auth::id();
        $images = Image::where('screen_id', $screen_id)
                        ->where('user_id', $userId)
                        ->get();

        return view('billboard', compact('images'));
    }
}
