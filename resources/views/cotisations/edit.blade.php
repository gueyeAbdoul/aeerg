@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la cotisation</h1>

    <form action="{{ route('cotisations.update', $cotisation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Membre</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $cotisation->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Montant</label>
            <input type="number" name="montant" step="0.01" class="form-control" value="{{ $cotisation->montant }}" required>
        </div>

        <div class="mb-3">
            <label>Date Paiement</label>
            <input type="date" name="date_paiement" class="form-control" value="{{ $cotisation->date_paiement }}">
        </div>

        <div class="mb-3">
            <label>Statut</label>
            <select name="statut" class="form-control" required>
                <option value="en_attente" {{ $cotisation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="payé" {{ $cotisation->statut == 'payé' ? 'selected' : '' }}>Payé</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Méthode</label>
            <select name="methode" class="form-control">
                <option value="">-- Choisir --</option>
                <option value="cash" {{ $cotisation->methode == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="mobile_money" {{ $cotisation->methode == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                <option value="virement" {{ $cotisation->methode == 'virement' ? 'selected' : '' }}>Virement</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
