import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '@/views/HomeView.vue';
import PqrsdView from '@/views/PqrsdView.vue';
import PqrsdDetail from '@/components/PqrsdDetail.vue';

const routes = [
  {
    path: '/',
    component: HomeView, // Página principal
  },
  {
    path: '/pqrsd',
    component: PqrsdView, // Vista que contiene la lista de PQRSD
  },
  {
    path: '/pqrsds/:id',
    component: PqrsdDetail,
    props: true, // Vista de detalle de una PQRSD
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;