<template>
    <div class="layout">
      <HeaderNavbar /> <!-- ✅ Navbar -->
  
      <main> <!-- ✅ Contenido Principal -->
        <router-view />
      </main>
  
      <FooterSection /> <!-- ✅ Footer -->
    </div>
  </template>
  
  <script setup>
  import HeaderNavbar from "@/components/layout-publico/HeaderNavbar.vue";
  import FooterSection from "@/components/layout-publico/FooterSection.vue";
  </script>
  
