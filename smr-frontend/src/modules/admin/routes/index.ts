import type { RouteRecordRaw } from 'vue-router';
import HomeAdmin from '../views/HomeAdmin.vue';

export const adminRoutes: RouteRecordRaw = {
  path: '/admin',
  name: 'admin',
  component: () => import('../layouts/AdminLayouts.vue'),
  redirect: { name: 'HomeAdmin.vue' },
  children: [
    {
      path: '/admin',
      name: 'HomeAdmin.vue',
      component: HomeAdmin,
    },
    {
      path: '/alcaldes',
      name: 'AlcaldePublico',
      component: () => import('@/modules/admin/alcaldes/views/AlcaldePublicoView.vue'),
    },

    {
      path: 'alcalde/:id',
      name: 'alcalde-actual',
      component: () => import('@/modules/admin/alcaldes/views/AlcaldeActual.vue'),
    },
    {
      path: '/plan',
      name: 'plandesarrollo',
      component: () => import('@/modules/admin/plandesarrollo/views/PlanDesarrollo.vue'),
    },
  ],
};

export default adminRoutes;
