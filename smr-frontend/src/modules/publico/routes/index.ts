import type { RouteRecordRaw } from 'vue-router';
import LayoutPublico from '../layouts/LayoutPublico.vue';
import HomePublico from '@/views/HomePublico.vue';

export const publicoRoutes: RouteRecordRaw = {
  path: '/',
  name: 'layoutpublico',
  component: LayoutPublico,
  redirect: { name: 'HomePublico.vue' },

  children: [
    {
      path: '/',
      name: 'HomePublico.vue',
      component: HomePublico,
    },
    {
      path: '/alcaldes',
      name: 'AlcaldePublico',
      component: () => import('@/modules/publico/alcaldes/views/AlcaldePublicoView.vue'),
    },

    {
      path: 'alcalde/:id',
      name: 'alcalde-actual',
      component: () => import('@/modules/publico/alcaldes/views/AlcaldeActual.vue'),
    },
    {
      path: '/plan',
      name: 'plandesarrollo',
      component: () => import('@/modules/publico/plandesarrollo/views/PlanDesarrollo.vue'),
    },
  ],
};

export default publicoRoutes;
