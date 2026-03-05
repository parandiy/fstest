<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileStorageService;

class FileUploadController extends Controller
{
    public function store(Request $request, FileStorageService $storage)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,docx',
                'max:10240'
            ]
        ]);

        $file = $storage->store($request->file('file'));

        return response()->json([
            'success' => true,
            'id' => $file->id
        ]);
    }
}
