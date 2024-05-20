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
    }
}
