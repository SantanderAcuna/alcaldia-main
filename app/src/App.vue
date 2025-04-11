<template>
  <div class="layout">
    <HeaderNavbar />
    <!-- ✅ Navbar -->

    <main>
      <!-- ✅ Carrusel  <router-view/> <Carrusel />-->
      
      <router-view />
      
    </main>

    <FooterSection />
    <!-- ✅ Footer -->
  </div>
</template>

<script setup>
import HeaderNavbar from "@/components/layout-publico/HeaderNavbar.vue";
import FooterSection from "@/components/layout-publico/FooterSection.vue";
import AccessibilityBar from "@/components/AccessibilityBar.vue";
//import Carrusel from "@/components/layout-publico/Carrusel.vue";
</script>

<style>
/* Importando Bootstrap y FontAwesome */
@import "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css";
@import "";
</style>
