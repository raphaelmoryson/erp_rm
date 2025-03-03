<?php

namespace App\Http\Controllers;

use App\Models\TechnicalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class TechnicalFileController extends Controller
{
    public function store(Request $request, $folderId)
    {
        $request->validate(['file' => 'required|file|mimes:pdf,jpg,png']);

        $file = $request->file('file');
        $path = $file->store('technical_files', 'public');

        TechnicalFile::create([
            'technical_folder_id' => $folderId, // Correction ici
            'file_name' => $request->file->getClientOriginalName(),
            'file_path' => $path,
        ]);
        

        return back()->with('success', 'Fichier ajouté avec succès.');
    }
}
