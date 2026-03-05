<?php

namespace App\Http\Controllers;

use App\Models\StoredFile;
use App\Services\FileDeletionService;

class FileController extends Controller
{
    public function index()
    {
        $files = StoredFile::latest()->paginate(15);

        return view('files.index', compact('files'));
    }

    public function destroy(
        StoredFile $file,
        FileDeletionService $service
    ) {
        $service->delete($file);

        return response()->json([
            'success' => true
        ]);
    }
}
