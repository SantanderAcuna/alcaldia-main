// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import Alcalde from "../views/Alcalde.vue";
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
];

// ─── Crear el router ─────────────────────────────────────────────────
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
