<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\User;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    /**
     * Constructeur : applique les règles d’accès selon le rôle.
     */

    /*
    public function __construct()
    {
        // Seuls Admin et Trésorier ont accès complet
        $this->middleware('checkRole:Admin,Trésorier')->except(['index']);

        // Tout le monde connecté (Admin, Trésorier, Responsable pédagogique, Membre)
        // peut consulter la liste des cotisations
        $this->middleware('checkRole:Admin,Trésorier,Responsable pédagogique,Membre')->only(['index']);
    }
*/
    /**
     * Affiche la liste des cotisations.
     */
    public function index()
    {
        $cotisations = Cotisation::with('user')->get();
        return view('cotisations.index', compact('cotisations'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $users = User::all();
        //dd($users);
        return view('cotisations.create', compact('users'));
    }

    /**
     * Enregistre une nouvelle cotisation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'montant'      => 'required|numeric|min:0',
            'date_paiement'=> 'nullable|date',
            'statut'       => 'required|in:payé,en_attente',
            'methode'      => 'nullable|in:cash,mobile_money,virement',
        ]);

        Cotisation::create($request->all());

        return redirect()->route('cotisations.index')->with('success', 'Cotisation ajoutée avec succès.');
    }

    // Page des cotisations de l'utilisateur connecté
    public function mesCotisations()
    {
        $cotisations = Cotisation::with('user')
            ->where('user_id', auth()->id())
            ->orderBy('date_paiement', 'desc')
            ->get();

        return view('cotisations.mescotisations', compact('cotisations'));
    }

    /**
     * Affiche le formulaire d’édition.
     */
    public function edit(Cotisation $cotisation)
    {
        $users = User::all();
        return view('cotisations.edit', compact('cotisation', 'users'));
    }

    /**
     * Met à jour une cotisation.
     */
    public function update(Request $request, Cotisation $cotisation)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'montant'      => 'required|numeric|min:0',
            'date_paiement'=> 'nullable|date',
            'statut'       => 'required|in:payé,en_attente',
            'methode'      => 'nullable|in:cash,mobile_money,virement',
        ]);

        $cotisation->update($request->all());

        return redirect()->route('cotisations.index')->with('success', 'Cotisation mise à jour avec succès.');
    }

    /**
     * Supprime une cotisation.
     */
    public function destroy(Cotisation $cotisation)
    {
        $cotisation->delete();
        return redirect()->route('cotisations.index')->with('success', 'Cotisation supprimée avec succès.');
    }
}
