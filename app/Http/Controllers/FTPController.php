<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FTPController extends Controller
{
    public function index()
    {
        $files = Storage::disk('ftp')->files(); 
        return view('files.index', compact('files'));  
    }

    public function showForm()
    {
        return view('upload_form');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        Log::info('Uploading file: ' . $fileName);

        if (Storage::disk('ftp')->exists($fileName)) {
            Log::error('File already exists: ' . $fileName);
            return back()->with('error', 'File ' . $fileName . ' already exists! Please generate another file.');
        }

        try {
            $path = Storage::disk('ftp')->put($fileName, file_get_contents($file));

            if ($path) {
                Log::info('File uploaded successfully: ' . $fileName . ' to path: ' . $path);
                return back()->with('success', 'File successfully uploaded to FTP!');
            } else {
                Log::error('File upload failed: ' . $fileName);
                return back()->with('error', 'An error occurred while uploading the file.');
            }
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $fileName . ' - ' . $e->getMessage());
            return back()->with('error', 'An error occurred while uploading the file.');
        }
    }

    public function download($file)
    {
        
        if (Storage::disk('ftp')->exists($file)) {
            
            $fileContents = Storage::disk('ftp')->get($file);

            
            return response($fileContents)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . basename($file) . '"');
        }

        
        return back()->with('error', 'File not found.');
    }


}
