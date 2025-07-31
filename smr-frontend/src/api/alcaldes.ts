import axios from 'axios';
import { apiConfig } from '@/api/apiConfig';

const ADMIN_BASE = '/admin/alcaldes';

export const createUpdateAlcalde = async (formData: FormData) => {
  try {
    const id = formData.get('id');
    let response;

    if (id) {
      formData.append('_method', 'PATCH');
      response = await apiConfig.post(`${ADMIN_BASE}/${id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
    } else {
      response = await apiConfig.post(ADMIN_BASE, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
    }

    return response.data;
  } catch (error) {
    handleAlcaldeError(error);
  }
};

const handleAlcaldeError = (error: unknown) => {
  if (axios.isAxiosError(error)) {
    const message = error.response?.status === 422
      ? parseValidationErrors(error.response.data.errors)
      : error.message;

    throw new Error(message);
  }
  throw new Error('Error desconocido');
};

const parseValidationErrors = (errors: Record<string, string[]>) => {
  return Object.entries(errors)
    .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
    .join('; ');
};

export const getAlcaldeById = async (id: number) => {
  const { data } = await apiConfig.get(`/publico/alcaldes/${id}`);
  return {
    ...data,
    fecha_inicio: new Date(data.fecha_inicio),
    fecha_fin: new Date(data.fecha_fin)
  };
};
