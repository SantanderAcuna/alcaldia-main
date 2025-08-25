import type { Alcalde } from './alcaldesInterfaces';
// import type { Documento } from './documentoInterfaces';

export interface ApiResponse {
  status: boolean;
  data?: PlanDesarrollo;
  error?: ApiError;
}

export interface ApiError {
  status: boolean;
  message: string;
}

export interface Documento {
  id?: number | null;
  plan_de_desarrollo_id?: number;
  path: string;
  nombre: string;
  url?: string;
  sizes?: number;
  pagination?: number;
}

export interface PlanDesarrollo {
  id: number;
  alcalde_id: number;
  titulo: string;
  descripcion: string;
  created_at?: string;
  updated_at?: string;
  deleted_at?: string | null;

  documentos?: Documento[] | null;
  alcalde?: Alcalde | null;
}
