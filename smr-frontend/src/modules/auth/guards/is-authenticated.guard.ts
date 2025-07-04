import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router';
import { useAuthStore } from '../stores/auth.store';
import { AuthStatus } from '../interfaces';

const isAuthenticatedGuard = async (
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext,
) => {
  const authStore = useAuthStore();

  // console.log(to);
  await authStore.checkAuthStatus();

  return authStore.authStatus === AuthStatus.Unauthenticated ? next({ name: 'Home' }) : next();
};

export default isAuthenticatedGuard;
