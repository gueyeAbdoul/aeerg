<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpruntController extends Controller
{
    public function index()
    {
        $emprunts = Emprunt::with(['document', 'user'])->get();
        return view('admin.emprunts.index', compact('emprunts'));
    }

   public function store(Request $request)
    {
        $user = auth()->user();
        $maxEmprunts = 2;

        // Vérifier le nombre d'emprunts actifs
        $nbActifs = Emprunt::where('user_id', $user->id)
            ->whereNull('date_retour_effective')
            ->count();

        if ($nbActifs >= $maxEmprunts) {
            return back()->with('error', 'Vous avez atteint le nombre maximal d\'emprunts.');
        }

        $request->validate([
            'document_id' => 'required|exists:documents,id',
        ]);

        $document = Document::with('emprunts')->findOrFail($request->document_id);

        // Vérifier si le document est disponible
        $actifs = $document->emprunts->whereNull('date_retour_effective')->count();
        if (!$document->is_disponible || $actifs > 0) {
            return back()->with('error', 'Ce document n\'est plus disponible.');
        }

        // Créer l'emprunt
        Emprunt::create([
            'user_id' => $user->id,
            'document_id' => $document->id,
            'date_emprunt' => now(),
            'date_retour_prevue' => now()->addDays(14), // exemple : 2 semaines de prêt
            'statut' => 'actif',
        ]);

        // Mettre à jour la dispo du document
        $document->update(['is_disponible' => false]);

        return back()->with('success', 'Document emprunté avec succès !');
    }


    public function update(Request $request, Emprunt $emprunt)
    {
        $this->authorizeAction();

        $request->validate([
            'statut' => 'required|in:actif,retard,rendu',
        ]);

        $emprunt->update([
            'statut' => $request->statut,
            'date_retour_effective' => $request->statut === 'rendu' ? now() : null,
        ]);

        if ($request->statut === 'rendu') {
            $emprunt->document->update(['is_disponible' => true]);
        }

        return redirect()->route('admin.emprunts.index')->with('success', 'Emprunt mis à jour.');
    }

    private function authorizeAction()
    {
        $role = Auth::user()->role?->nom;
        if (!in_array($role, ['Admin', 'Responsable pédagogique'])) {
            abort(403, 'Accès non autorisé.');
        }
    }

    // Liste des emprunts de l’utilisateur connecté
   // Liste des emprunts de l’utilisateur connecté
    public function mesEmprunts()
    {
        $emprunts = Emprunt::where('user_id', auth()->id())
            ->with('document')
            ->get();

        // On charge tous les documents marqués disponibles + leurs emprunts
        $documentsDisponibles = Document::where('is_disponible', true)
            ->with('emprunts') // pour pouvoir compter les actifs dans la vue
            ->get();

        return view('admin.emprunts.mesemprunts', compact('emprunts', 'documentsDisponibles'));
    }
}
