import type { PlanDesarrollo } from './planDesarrollointerfaces';

export interface ApiResponse {
  status: boolean;
  data?: Alcalde;
  error?: ApiError;
}

export interface ApiError {
  status: boolean;
  message: string;
}

export interface Alcalde {
  id: number;
  nombre_completo: string;
  presentacion: string;
  fecha_inicio: string;
  fecha_fin: string;
  sexo: 'masculino' | 'femenino';
  actual: boolean;
  foto_path: string;
  plan_desarrollo?: PlanDesarrollo;
  document_url?: string | null;
  created_at?: string;
  updated_at?: string;
  deleted_at?: string | null;
}
