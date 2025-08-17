<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<!-- resources/js/Pages/Auth/Register.vue -->
<template>
    <form @submit.prevent="submit">
        <!-- Nom -->
        <div>
            <InputLabel for="nom" value="Nom" />
            <TextInput
                id="nom"
                v-model="form.nom"
                type="text"
                required
                autofocus
            />
            <InputError :message="form.errors.nom" />
        </div>

        <!-- Prénom -->
        <div class="mt-4">
            <InputLabel for="prenom" value="Prénom" />
            <TextInput
                id="prenom"
                v-model="form.prenom"
                type="text"
                required
            />
            <InputError :message="form.errors.prenom" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput
                id="email"
                v-model="form.email"
                type="email"
                required
            />
            <InputError :message="form.errors.email" />
        </div>

        <!-- Téléphone -->
        <div class="mt-4">
            <InputLabel for="telephone" value="Téléphone (Sénégal)" />
            <TextInput
                id="telephone"
                v-model="form.telephone"
                type="tel"
                required
                placeholder="77 123 45 67"
            />
            <InputError :message="form.errors.telephone" />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <InputLabel for="password" value="Mot de passe" />
            <TextInput
                id="password"
                v-model="form.password"
                type="password"
                required
                autocomplete="new-password"
            />
            <InputError :message="form.errors.password" />
        </div>

        <!-- Confirmation mot de passe -->
        <div class="mt-4">
            <InputLabel for="password_confirmation" value="Confirmation" />
            <TextInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                required
            />
            <InputError :message="form.errors.password_confirmation" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                :href="route('login')"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
                Déjà inscrit ?
            </Link>

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                S'inscrire
            </PrimaryButton>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    nom: '',
    prenom: '',
    email: '',
    telephone: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
