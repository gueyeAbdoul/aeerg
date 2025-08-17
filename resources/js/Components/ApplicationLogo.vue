<template>
  <div class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg py-12 flex flex-col items-center">
    <!-- Logo AEERG -->
    <img
      src="/image/logo-aeerg.png"
      alt="Logo AEERG"
      class="w-32 h-32 mb-6 object-contain rounded-full border-4 border-white shadow-md"
    />

    <!-- Titre centré sous le logo -->
    <h1
      class="text-center text-white text-lg md:text-2xl font-bold bg-white bg-opacity-20 px-4 py-2 rounded-lg max-w-xl"
    >
      ASSOCIATION DES ELEVES ET ETUDIANTS RESSORTISSANT DE GOUYE REINE
    </h1>
  </div>
</template>

<script>
export default {
  name: "ApplicationLogo",
};
</script>

<style scoped>
/* Effet hover sur le logo pour un petit zoom */
img {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

img:hover {
  transform: scale(1.08);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

/* Optionnel : légère animation d'apparition du titre */
h1 {
  animation: fadeIn 1s ease forwards;
  opacity: 0;
}

@keyframes fadeIn {
  to {
    opacity: 1;
  }
}
</style>
