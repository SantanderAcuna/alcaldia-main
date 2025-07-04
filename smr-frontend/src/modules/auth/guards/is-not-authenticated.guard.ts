import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router';
import { useAuthStore } from '@/modules/auth/stores/auth.store';
import { AuthStatus } from '../interfaces';

export const isNotAuthenticatedGuard = async (
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext,
) => {
  const authStore = useAuthStore();

  // console.log(to);
  await authStore.checkAuthStatus();

  return authStore.authStatus === AuthStatus.Authenticated ? next({ name: 'Home' }) : next();
};

// export default isNotAuthenticatedGuard;
