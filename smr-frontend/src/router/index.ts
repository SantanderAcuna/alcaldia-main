import { createRouter, createWebHistory } from 'vue-router';
import  layoutpublico from '@/layouts/LayoutPublico.vue'
import  HomePublico from '@/views/HomePublico.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'layoutpublico',
      component: layoutpublico,
      children: [
        {
          path: '/',
          name: 'HomePublico.vue',
          component: HomePublico,
        },
        {
          path: '/alcaldes',
          name: 'AlcaldePublico',
          component: () => import('@/modules/alcaldes/views/AlcaldePublicoView.vue'),
        },

        {
          path: 'alcalde/:id',
          name: 'alcalde-actual',
          component: () => import('@/modules/alcaldes/views/AlcaldeActual.vue'),
        },
        {
          path: '/plan',
          name: 'plandesarrollo',
          component: () => import('@/modules/plandesarrollo/views/PlanDesarrollo.vue'),
        },
      ],
    },
  ],
});

export default router;
