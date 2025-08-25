import type { Cargo } from './cargoInterfaces';

export interface Funcionario {
  id?: number | null;
  nombres?: string;
  apellidos?: string;
  cargo_id?: number;
  dependencia_id?: number | null;
  genero?: string;
  departamento?: string;
  municipio?: string;
  estado?: boolean;
  cargo?: Cargo;
  foto?: string;
}
