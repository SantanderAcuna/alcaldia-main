import { apiConfig } from '@/api/apiConfig';
import axios, { AxiosError } from 'axios';

// actions.ts
export const deleteAlcalde = async (alcaldeId: number): Promise<void> => {
  try {
    await apiConfig.delete(`/admin/alcaldes/${alcaldeId}`);
  } catch (error) {
    if (axios.isAxiosError(error)) {
      const axiosError = error as AxiosError;
      if (axios.isAxiosError(axiosError) && axiosError.response?.data) {
        const errorMessages = Object.values(error).flat().join(', ');
        throw new Error(`Error de validación: ${errorMessages}`);
      }
      throw new Error(axiosError.message || 'Error en la solicitud');
    }
    throw new Error('Error desconocido al procesar la solicitud');
  }
};
