import { apiConfig } from '@/api/apiConfig';
import axios, { AxiosError } from 'axios';
import { useToast } from 'vue-toast-notification';
const $toast = useToast();

export const deleteSecretaria = async (secretariaId: number): Promise<void> => {
  try {
    await apiConfig.delete(`/admin/secretarias-admin/${secretariaId}`);
    $toast.success('Secretaria eliminado con éxito');
  } catch (error) {
    $toast.error('Error eliminando secretaria:' + `${error}`);
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
