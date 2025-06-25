import type { PlanDesarrollo } from './planDesarrollointerfaces';

export interface Alcaldes {
  id: number;
  nombre_completo: string;
  fecha_inicio: Date;
  fecha_fin: Date;
  presentacion: string;
  foto_path: string;
  actual: boolean;

  plan_desarrollo: PlanDesarrollo;
}
