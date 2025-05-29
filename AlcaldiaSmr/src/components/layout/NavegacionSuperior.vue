<template>
  <!-- Navegación Superior -->
  <nav
    class="py-2 navbar navbar-expand-lg border-bottom"
    style="background-color: #00568d"
  >
    <div class="container">
      <a href="https://www.gov.co/" target="_blank" rel="noopener">
        <img :src="logoIcon" alt="GOV.CO" style="height: 40px" />
      </a>
      <div class="gap-4 d-flex align-items-center">
        <button class="btn btn-sm btn-outline-light">
          <i class="fas fa-globe me-1"></i>EN
        </button>
        <div class="gap-3 d-none d-md-flex">
          <router-link to="#" class="text-white small">
            <i class="fas fa-universal-access me-1"></i>Accesibilidad
          </router-link>
          <router-link to="#" class="text-white small">
            <i class="fas fa-sitemap me-1"></i>Mapa del sitio
          </router-link>
        </div>
      </div>
    </div>
  </nav>

  <!-- Logos Institucionales -->
  <div class="container py-4">
    <div class="flex-wrap d-flex align-items-center justify-content-between">
      <div class="flex-wrap gap-4 d-flex align-items-center">
        <img
          :src="logo500Icon"
          alt="500 Años"
          class="img-fluid"
          style="max-height: 80px"
          loading="lazy"
        />
        <img
          :src="catastralIcon"
          alt="Catastro"
          class="img-fluid"
          style="max-height: 60px"
          loading="lazy"
        />
      </div>

      <div class="gap-3 d-none d-lg-flex">
        <router-link to="#" class="text-dark"
          ><i class="fab fa-facebook fa-lg"></i
        ></router-link>
        <router-link to="#" class="text-dark"
          ><i class="fab fa-twitter fa-lg"></i
        ></router-link>
        <router-link to="#" class="text-dark"
          ><i class="fab fa-instagram fa-lg"></i
        ></router-link>
        <router-link to="#" class="text-dark"
          ><i class="fab fa-youtube fa-lg"></i
        ></router-link>
      </div>
    </div>
  </div>
</template>

<script setup>


import logo500Icon from "@/assets/img/logos/logo500Or.png";
import catastralIcon from "@/assets/img/logos/favicon.png";
import logoIcon from "@/assets/img/logos/gov.svg";


</script>
