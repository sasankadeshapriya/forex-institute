<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,zip|max:10240',
        ]);

        // Handle the file upload
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $filePath = $file->storeAs('', $fileName, 'private');

        return response()->json(['message' => 'File uploaded successfully!', 'file_path' => $filePath], 200);
    }

    public function download($fileName)
    {
        $filePath = storage_path('app/private/contents/' . $fileName);

        if (!file_exists($filePath)) {
            return abort(404);
        }

        return response()->download($filePath);
    }

}
