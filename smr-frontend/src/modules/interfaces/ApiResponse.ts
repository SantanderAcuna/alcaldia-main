// Definición de interfaz genérica
export interface ApiResponse<T> {
  status: boolean;
  data: T;
}
