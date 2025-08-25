import type { Dependencia } from './dependenciaInterfaces';
import type { Funcionario } from './funcionarioIterfaces';
import type { Funciones } from './funcioneIterfaces';
import type { Tramite } from './tramiteInterfaces';

// Interfaces principales
export interface Secretaria {
  id?: number | null |typeof NaN;
  nombre?: string;
  mision?: string;
  vision?: string;
  organigrama?: string;
  created_at?: string;
  updated_at?: string;
  funciones?: Funciones[];
  dependencias?: Dependencia[];
  tramites?: Tramite[];
  funcionarios?: Funcionario[];
}
