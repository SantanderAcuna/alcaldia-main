export interface ApiResponse<T> {
  status?: boolean;
  data?: T;
  error?: ApiError;
}

export interface ApiError {
  status?: boolean;
  message?: string;
  response?:string
}
