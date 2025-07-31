import type { RouteRecordRaw } from 'vue-router';
import HomeAdmin from '@/modules/admin/views/HomeAdmin.vue';

export const adminRoutes: RouteRecordRaw = {
  path: '/admin',
  name: 'admin-layout',
  component: () => import('@/modules/admin/layouts/AdminLayouts.vue'),
  meta: { isLayout: true },
  redirect: { name: 'Dashboard' },
  children: [
    {
      path: '',
      name: 'Dashboard',
      component: HomeAdmin,
    },
    {
      path: '/admin/alcaldes',
      name: 'listado-alcaldes',
      component: () => import('@/modules/admin/alcaldes/views/AlcaldeAdminView.vue'),
    },
    {
      path: '/admin/alcaldes/create',
      name: 'crear-alcaldes',
      component: () => import('@/modules/admin/alcaldes/views/AlcaldeCreateAdmin.vue'),
    },
    {
      path: '/admin/alcaldes/actual/:id',
      name: 'alcalde-actual',
      component: () => import('@/modules/admin/alcaldes/views/AlcaldeActualAdmin.vue'),
      props: true,
    },
    {
      path: '/admin/alcaldes/:id',
      name: 'detalle-alcaldes',
      component: () => import('@/modules/admin/alcaldes/views/AlcaldeDetalleAdmin.vue'),
      props: true,
    },
    {
      path: '/admin/plan',
      name: 'plan-desarrollo',
      component: () => import('@/modules/admin/plandesarrollo/views/PlanDesarrollo.vue'),
    },
  ],
};

export default adminRoutes;
