<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DownloadDocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('download.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_hindi' => 'required|string|max:255',
            'file'  => 'required|mimes:pdf,doc,docx,jpg,png|max:10240'
        ]);
        
        $fileName = time() . '-' . $request->file('file')->getClientOriginalName();
        $request->file('file')->move(public_path('documents'), $fileName);

        Document::create([
            'title' => $request->title,
            'title_hindi' => $request->title_hindi,
            'file_path' => 'documents/' . $fileName
        ]);

        return back()->with('success', 'Document uploaded successfully');
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'title_hindi' => 'required|string|max:255',
            'file'  => 'nullable|mimes:pdf,doc,docx,jpg,png|max:10240'
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path && file_exists(public_path($document->file_path))) {
                unlink(public_path($document->file_path));
            }

            $fileName = time() . '-' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('documents'), $fileName);
            $document->file_path = 'documents/' . $fileName;
        }

        $document->title = $request->title;
        $document->title_hindi = $request->title_hindi;
        $document->save();

        return back()->with('success', 'Document updated successfully');
    }


    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        if ($document->file_path && file_exists(public_path($document->file_path))) {
            unlink(public_path($document->file_path));
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully');
    }
}
