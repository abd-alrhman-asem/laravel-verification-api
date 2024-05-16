<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// For file storage

class FileService
{
    /**
     * @param Request $request
     * @param string $fileKey
     * @param $path
     * @return string|null
     */
    public function handleFile(Request $request, string $fileKey, $path): ?string
    {
        if (!$request->hasFile($fileKey)) {
            return null;
        }
        $file = $request->file($fileKey);
        $fileName = microtime() . '.' . $file->getClientOriginalExtension();
        return $file->move(storage_path($path), $fileName);




//        $file_name = microtime() . '.' . $request->file($fileKey)->getClientOriginalExtension();
//        $file = $request->file($fileKey)->storeAs($path , $file_name);
//        $file->storeAs($path , $file_name);
//        Storage::disk('local')-> putFileAs($path, $file, $filename);
//        Storage::disk('local')-> put('example.txt', 'Contents');


    }
}
