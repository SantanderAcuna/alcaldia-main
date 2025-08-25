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
    // Alcaldes
    {
      path: '/admin/alcaldes',
      name: 'alcaldes',
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

    // Plan de desarrollo
    {
      path: '/admin/plan',
      name: 'plan-desarrollo',
      component: () => import('@/modules/admin/plandesarrollo/views/PlanDesarrollo.vue'),
    },
    // Secretarias
    {
      path: '/admin/secretarias',
      name: 'secretarias',
      component: () => import('@/modules/admin/dependencias/views/SecretariaListAdmin.vue'),
    },
    {
      path: '/admin/secretarias/create',
      name: 'crear-secretaria',
      component: () => import('@/modules/admin/dependencias/views/SecretariaCrearUpdateAdmin.vue'),
    },
    {
      path: '/admin/secretarias/:id',
      name: 'editar-secretaria',
      component: () => import('@/modules/admin/dependencias/views/SecretariaEdicionAdmin.vue'),
      props: true,
    },
    {
      path: '/admin/secretarias/:id',
      name: 'detalles-secretaria',
      component: () => import('@/modules/admin/dependencias/views/SecretariaDetallesAdmin.vue'),
      props: true,
    },
  ],
};

export default adminRoutes;
