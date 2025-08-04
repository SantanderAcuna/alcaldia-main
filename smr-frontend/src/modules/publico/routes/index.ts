// src/router/publicoRoutes.ts
import type { RouteRecordRaw } from 'vue-router';

import LayoutPublico from '../layouts/LayoutPublico.vue';
import HomePublico from '@/views/HomePublico.vue';

export const publicoRoutes: RouteRecordRaw = {
  path: '/',
  name: 'LayoutPublico',
  component: LayoutPublico,
  meta: { isLayout: true },
  redirect: { name: 'Inicio' },

  children: [
    {
      // / → HomePublico
      path: '',
      name: 'Inicio',
      component: HomePublico,
    },
    {
      // /alcaldes → listado público
      path: 'alcaldes',
      name: 'listado-de-alcaldes',
      component: () => import('@/modules/publico/alcaldes/views/AlcaldePublicoView.vue'),
    },
    {
      // /alcalde/:id → detalle público
      path: '/publico/alcaldes/actual/:id',
      name: 'publico-alcalde-actual',
      component: () => import('@/modules/publico/alcaldes/views/AlcaldeActual.vue'),
      props: true,
    },

    {
      // /plan → planes de desarrollo público
      path: 'plan',
      name: 'plan-de-desarrollo',
      component: () => import('@/modules/publico/plandesarrollo/views/PlanDesarrollo.vue'),
    },
  ],
};

export default publicoRoutes;
