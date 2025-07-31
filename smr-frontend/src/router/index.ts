import { createRouter, createWebHistory } from 'vue-router';

import publicoRoutes from '@/modules/publico/routes';
import adminRoutes from '@/modules/admin/routes';
import authRoutes from '@/modules/auth/routes';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [publicoRoutes, adminRoutes, authRoutes],
});

export default router;
