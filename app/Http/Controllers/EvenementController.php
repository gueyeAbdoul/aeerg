<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EvenementController extends Controller
{
    use AuthorizesRequests;
    // Liste des événements (calendrier)
    public function index()
    {
        $evenements = Evenement::all();

        // Préparer les données pour FullCalendar
        $events = $evenements->map(function ($event) {
            return [
                'title' => $event->titre,
                'start' => $event->date_debut,
                'end'   => $event->date_fin,
                'url'   => route('evenements.show', $event),
            ];
        });

        return view('evenements.index', [
            'evenements' => $evenements,
            'events' => $events
        ]);
    }

    // Création (admin + responsable pédagogique)
    public function create()
    {
        return view('evenements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'lieu' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        Evenement::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'lieu' => $request->lieu,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'createur_id' => Auth::id(),
        ]);

        return redirect()->route('evenements.index')
                        ->with('success', 'Événement créé avec succès ✅');
    }

    // Détails d’un événement
    public function show(Evenement $evenement)
    {
        return view('evenements.show', compact('evenement'));
    }

    // Inscription à un événement
    public function inscrire(Evenement $evenement)
    {
        $user = Auth::user();

        if (!$evenement->participants->contains($user->id)) {
            $evenement->participants()->attach($user->id);
        }

        return redirect()->route('evenements.show', $evenement)->with('success', 'Inscription réussie !');
    }

    // Désinscription
    public function desinscrire(Evenement $evenement)
    {
        $user = Auth::user();
        $evenement->participants()->detach($user->id);

        return redirect()->route('evenements.show', $evenement)->with('success', 'Désinscription effectuée.');
    }

    public function json()
    {
        $events = \App\Models\Evenement::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->titre,
                'start' => $event->date_debut,
                'end' => $event->date_fin,
                'url' => route('evenements.show', $event), // clic → détail
            ];
        });

        return response()->json($events);
    }

    // Affiche le formulaire pour modifier un événement
    public function edit(Evenement $evenement)
    {

        return view('evenements.edit', compact('evenement'));
    }

    // Met à jour l'événement en base
    public function update(Request $request, Evenement $evenement)
    {

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'lieu' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $evenement->update($request->only('titre', 'description', 'lieu', 'date_debut', 'date_fin'));

        return redirect()->route('evenements.index')
                        ->with('success', 'Événement mis à jour avec succès ✅');
    }

    // Supprime un événement
    public function destroy(Evenement $evenement)
    {

        $evenement->delete();

        return redirect()->route('evenements.index')
                        ->with('success', 'Événement supprimé avec succès ✅');
    }

}
