// interfaces/auth.interface.ts
export interface AuthResponse {
  ok: boolean;
  user: User;
  token: string;
  message?: string;
}

export interface LoginResponse {
  ok: boolean;
  user?: User;
  token?: string;
  message?: string;
}

export interface RegisterResponse {
  ok: boolean;
  user?: User;
  token?: string;
  message?: string;
}

export interface User {
  id: string;
  fullName: string;
  email: string;
  isActive: boolean;
  roles: string[];
  // ... otras propiedades
}

export enum AuthStatus {
  Checking = 'checking',
  Authenticated = 'authenticated',
  NotAuthenticated = 'not-authenticated'
}
