import type { Alcalde } from './alcaldesInterfaces';
import type { Documento } from './documentoInterfaces';

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


