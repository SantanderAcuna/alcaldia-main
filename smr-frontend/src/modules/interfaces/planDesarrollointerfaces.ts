import type { Alcaldes } from './alcaldesInterfaces';

export interface PlanDesarrollo {
  id: number;
  titulo: string;
  descripcion: string;
  documentos: Documento[]; // ← calculado en frontend
  alcalde_id: number;

  alcalde?: Alcaldes;
}

export interface PlanDesarrollo {
  id: number;
  alcalde_id: number;
  titulo: string;
  descripcion: string;
  documentos: Documento[]; // Array de documentos
}

export interface Documento {
  id?: number;
  plan_de_desarrollo_id?: number;
  path: string;
  nombre: string;
}
