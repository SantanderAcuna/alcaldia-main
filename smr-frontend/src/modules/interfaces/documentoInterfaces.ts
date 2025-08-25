export interface ApiResponse {
  status: boolean;
  data?: Documento;
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
