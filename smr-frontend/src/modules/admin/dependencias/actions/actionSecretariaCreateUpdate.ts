import axios, { AxiosError } from 'axios';
import { apiConfig } from '@/api/apiConfig';

import type { Secretaria } from '@/modules/interfaces';
import { useToast } from 'vue-toast-notification';

const $toast = useToast();

const ADMIN_BASE = '/admin/secretarias-admin';

interface ErrorResponse {
  errors?: Record<string, string[]>;
}

export const createUpdateSecretaria = async (formData: FormData): Promise<Secretaria> => {
  try {
    const id = formData.get('id');
    const isUpdate = id && id !== 'undefined';
    const url = isUpdate ? `${ADMIN_BASE}/${id}` : ADMIN_BASE;

    const config = {
      headers: { 'Content-Type': 'multipart/form-data' },
      timeout: 30000,
    };

    const { data } = isUpdate
      ? await apiConfig.post(url, formData, config)
      : await apiConfig.post(url, formData, config);

    $toast.success('Transaccion exitosa');

    return data;
  } catch (error) {
    if (axios.isAxiosError(error)) {
      const axiosError = error as AxiosError;
      if (axios.isAxiosError(axiosError) && axiosError.response?.data) {
        const errors = (axiosError.response.data as ErrorResponse).errors || {};

        const errorMessages = Object.values(errors).flat().join(', ');
        throw new Error(`Error de validación: ${errorMessages}`);
      }
      $toast.error('Error en la solicitud');
      throw new Error(axiosError.message || 'Error en la solicitud');
    }
    throw new Error('Error desconocido al procesar la solicitud');
  }
};
