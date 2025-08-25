import type { Proceso } from "./procesosInterfaces";

export interface Macroproceso {
  id?: number | null;
  macrop?: string;
  codigo?: string;
  descripcion?: string;
  dependencia_id?: number | null;
  procesos?: Proceso[];
}
