// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import Alcalde from "../views/alcaldia-view/publico/Alcalde.vue";
import AlcaldeViews from "../views/alcaldia-view/admin/AlcaldeViews.vue";
import GabineteView from "../views/gabinete/GabineteView.vue";
import PublicacionesView from "../views/publicaciones/PublicacionesView.vue";

// ─── Rutas principales ───────────────────────────────────────────────

// ─── Definición de rutas ─────────────────────────────────────────────
const routes = [
  
  { path: "/alcaldes", name: "alcaldes", component: Alcalde },
  { path: "/gabinete", name: "gabinetes", component: GabineteView },
  {
    path: "/publicaciones",
    name: "publicaciones",
    component: PublicacionesView,
  },

  // Rutas de administración
  { path: "/alcaldes-view", name: "alcaldes-view", component: AlcaldeViews }, 
];

// ─── Crear el router ─────────────────────────────────────────────────
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
