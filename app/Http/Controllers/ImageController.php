<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index($screen_id)
    {
        $images = Image::where('screen_id', $screen_id)
        ->where('user_id', Auth::id())
        ->get();

        return view('imageUpload', compact('images', 'screen_id'));
    }

    public function store(Request $request)
    {

        $request->validate([
            "images" => "required",
            "images.*" => "image|mimes:jpg,jpeg,png,gif,svg|max:2048"
        ]);

        foreach ($request->file('images') as $key => $image) {
            $imageName = time() . '_' . $key . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            Image::create([
                "name" => $imageName,
                "screen_id" => $request->screen_id,
                "user_id" => Auth::id(),
            ]);
        }

        return back()->with('success', 'You have successfully upload images.');
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // Delete the image file from public/images
        $imagePath = public_path('images/' . $image->name);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete from database
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
