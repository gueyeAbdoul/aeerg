<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $documents = $query->with('proprietaire')->get();
        // dd($documents);
        // $documents = Document::with('proprietaire')->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    public function create()
    {
        $this->authorizeAction();
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAction();

        $request->validate([
            'titre' => 'required|string|max:255',
            'chemin_fichier' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,txt|max:20480',
        ]);

        $path = $request->file('chemin_fichier')->store('documents', 'public');

        Document::create([
            'titre' => $request->titre,
            'categorie' => $request->categorie,
            'chemin_fichier' => $path,
            'proprietaire_id' => Auth::id(),
            'date_ajout' => now(),
            'is_disponible' => true,
        ]);

        return redirect()->route('gestion.ressources')->with('success', 'Document ajouté avec succès.');
    }

    public function edit(Document $document)
    {
        $this->authorizeAction();
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorizeAction();

        $request->validate([
            'titre' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'is_disponible' => 'required|boolean',
        ]);

        $document->update($request->only('titre','categorie', 'is_disponible'));

        return redirect()->route('gestion.ressources')->with('success', 'Document mis à jour.');
    }

    public function destroy(Document $document)
    {
        $this->authorizeAction();

        $document->delete();
        return redirect()->route('gestion.ressources')->with('success', 'Document supprimé.');
    }

    private function authorizeAction()
    {
        $role = Auth::user()->role?->nom;
        if (!in_array($role, ['Admin', 'Responsable pédagogique'])) {
            abort(403, 'Accès non autorisé.');
        }
    }
}
