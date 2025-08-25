import type { Competencia } from './competenciasInterfaces';
import type { Funcionario } from './funcionarioIterfaces';
import type { Macroproceso } from './macroprocesosInterfaces';
import type { Tramite } from './tramiteInterfaces';

export interface Dependencia {
  id?: number | null | typeof NaN;
  dependencia?: string;
  tipo?: string;
  dependencia_padre_id?: number | null;
  descripcion?: string;
  mision?: string;
  vision?: string;
  organigrama?: string | null;
  parent?: Dependencia | null;
  children?: Dependencia[];
  funcionarios?: Funcionario[];
  competencias?: Competencia[];
  tramites?: Tramite[];
  macroprocesos?: Macroproceso[];
}
