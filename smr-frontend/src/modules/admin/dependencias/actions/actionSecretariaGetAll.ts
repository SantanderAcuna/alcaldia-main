import { apiConfig } from '@/api/apiConfig';

import { getImageAction } from './actionSecretariaImagen';
import type { Secretaria } from '@/modules/interfaces';

interface ApiResponse<T> {
  status: boolean;
  data: T;
}

/**
 * Obtiene la lista de secretarias con sus  documentos
 * @param page - Página actual (1-based)
 * @param limit - Cantidad de registros por página
 * @returns Promise con array de Alcaldes procesados
 */
export const getSecretariaAll = async (
  page: number = 1,
  limit: number = 10,
): Promise<Secretaria[]> => {
  try {
    // 1. Hacer la petición a la API con tipado fuerte
    const { data: response } = await apiConfig.get<ApiResponse<Secretaria[]>>(
      `/admin/dependencias-admin?limit=${limit}&offset=${(page - 1) * limit}`,
    );

    console.log(response);

    // 2. Validar respuesta básica
    if (!response.status || !Array.isArray(response.data)) {
      console.warn('Respuesta API inválida:', response);
      return [];
    }

    // 3. Procesar cada secretaria
    return response.data.map((secretaria) => {
      // Convertir array plan_desarrollo a objeto único (tomamos el primer elemento si existe)

      const funcionario =
        Array.isArray(secretaria.funcionarios) && secretaria.funcionarios.length > 0
          ? secretaria.funcionarios[0]
          : undefined;

      // Procesar foto si existen
      const funcionarioAll = funcionario
        ? {
            ...funcionario,
            foto: getImageAction(funcionario.foto), // Paréntesis cerrado aquí
          }
        : undefined;

      return {
        ...secretaria,
        organigrama: getImageAction(secretaria.organigrama),
        funcionario: funcionarioAll,
      };
    });
  } catch (error) {
    console.error('Error fetching alcaldes:', error);
    throw new Error('Failed to fetch alcaldes data');
  }
};
