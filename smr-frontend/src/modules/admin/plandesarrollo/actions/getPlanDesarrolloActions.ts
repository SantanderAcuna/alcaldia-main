import { apiConfig } from '@/api/apiConfig';
import type { PlanDesarrollo } from '@/modules/interfaces';

import axios from 'axios';
import { getDocumentUrlAction } from './getDocumentActions';

interface PaginationLinks {
  url: string | null;
  label: string;
  active: boolean;
}

interface PaginatedResponse {
  current_page: number;
  data: PlanDesarrollo[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  links: PaginationLinks[];
  next_page_url: string | null;
  path: string;
  per_page: number;
  prev_page_url: string | null;
  to: number;
  total: number;
}

interface ApiResponse {
  status: boolean;
  data?: PaginatedResponse;
  message?: string;
  error?: string;
}

interface PlanDesarrolloResponse {
  status: boolean;
  data?: PlanDesarrollo[];

  error?: string;
}

export const getPlanDesarrolloActions = async (
  page = 1,
  limit = 10,
): Promise<PlanDesarrolloResponse> => {
  try {
    const response = await apiConfig.get<ApiResponse>('/admin/plan-admin', {
      params: {
        page,
        per_page: limit,
        timestamp: Date.now(),
      },

      // Aceptar respuestas 500 para manejar el error
      validateStatus: (status) => status >= 200 && status < 600,
    });

 

    // Manejar errores 500 del servidor
    if (response.status >= 500) {
      throw new Error(
        response.data?.error ||
          response.data?.message ||
          `Error ${response.status}: Error interno del servidor`,
      );
    }

    // Manejar otros errores no exitosos
    if (response.status !== 200 || !response.data?.status || !response.data.data) {
      const errorMessage =
        response.data?.message ||
        response.data?.error ||
        `Error ${response.status}: ${response.statusText}`;

      throw new Error(errorMessage);
    }

    const apiData = response.data.data;

    // Validar estructura de datos
    if (!Array.isArray(apiData.data)) {
      console.error('Datos inválidos recibidos:', apiData);
      throw new Error('La estructura de datos recibida es inválida');
    }

    // Transformar documentos
    const transformedData = {
      status: true,
      data: apiData.data.map((plan) => ({
        ...plan,
        documentos:
          plan.documentos?.map((doc) => ({
            ...doc,
            url: getDocumentUrlAction(doc.path),
          })) || [],
      })),
      total: apiData.total,
      current_page: apiData.current_page,
      last_page: apiData.last_page,
      per_page: apiData.per_page,
    };

    return transformedData;
  } catch (error) {
    // Manejo detallado de errores
    let errorMessage = 'Error desconocido al obtener planes de desarrollo';
    if (axios.isAxiosError(error)) {
      // Error de Axios
      errorMessage = error.message || 'Error de red al obtener planes de desarrollo';
    } else if (error instanceof Error) {
      // Error genérico
      errorMessage = error.message || error.toString();
    } else {
      console.log('Error inesperado:', error);
    }

    console.error('Error fetching planes de desarrollo:', errorMessage, error);

    // Retornar estructura de error para que el componente pueda mostrarlo
    return {
      status: false,
      data: [],

      error: errorMessage,
    };
  }
};
