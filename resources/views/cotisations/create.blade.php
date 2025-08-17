@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une cotisation</h1>

    <form action="{{ route('cotisations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Membre</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Montant</label>
            <input type="number" name="montant" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date Paiement</label>
            <input type="date" name="date_paiement" class="form-control">
        </div>

        <div class="mb-3">
            <label>Statut</label>
            <select name="statut" class="form-control" required>
                <option value="en_attente">En attente</option>
                <option value="payé">Payé</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Méthode</label>
            <select name="methode" class="form-control">
                <option value="">-- Choisir --</option>
                <option value="cash">Cash</option>
                <option value="mobile_money">Mobile Money</option>
                <option value="virement">Virement</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
