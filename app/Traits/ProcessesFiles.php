<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait ProcessesFiles
{
    public function storePhoto(Request $request, $path, $directory) {
        $image = $request->file('image');

        $image_name = date('Ymd') . '-' . mt_rand(0, 99999) . '.' . $image->getClientOriginalExtension();

        $image->move($path, $image_name);

        $file = 'images/' . $directory . '/' . $image_name;

        Storage::disk($directory)->put($image_name, file_get_contents($file));

        return $image_name;
    }

    public function verifyPhotoLocation($file_name, $directory) {
        if($file_name === null || $file_name === "" || !preg_match('/^[\w&.\-]+\.+[jpeg|jpg|png|webp|jfif|PNG|JPEG|JPG|WEBP|JFIF]+$/', $file_name)) {
            return false;
        } else {
            $image_directory = asset('images/' . $directory . '/' . $file_name);

            if (!File::exists($image_directory)) {
                return true;
            }

            return false;
        }
    }
}
