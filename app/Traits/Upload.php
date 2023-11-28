<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait Upload
{
    public function uploadFile($file, $path)
    {
        if($file){
            $filename = time().rand(1,99).'.'.$file->getClientOriginalExtension();
            $upload_path = "images/$path";
            $file->move(public_path($upload_path), $filename);
            return $path.'/'.$filename;
        }
    }

    public function deleteFile($path)
    {
        if(File::exists(public_path('images/'.$path))) {
            File::delete(public_path('images/'.$path));
        }
        return true;
    }
}
