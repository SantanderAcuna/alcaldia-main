import { apiConfig } from '@/api/apiConfig';
import type { Alcalde } from '@/modules/interfaces/alcaldesInterfaces';
import { getDocumentUrlAction } from './getDocumenAdmintActions';
import { getImageAction } from './getImageAdminAction';

interface ApiResponse<T> {
  status: boolean;
  data: T;
}

export interface Documento {
  id?: number | null;
  plan_de_desarrollo_id?: number;
  path: string;
  nombre: string;
  url?: string;
}

/**
 * Obtiene la lista de alcaldes con sus planes de desarrollo y documentos
 * @param page - Página actual (1-based)
 * @param limit - Cantidad de registros por página
 * @returns Promise con array de Alcaldes procesados
 */
export const getAlcaldeActions = async (
  page: number = 1,
  limit: number = 10,
): Promise<Alcalde[]> => {
  try {
    // 1. Hacer la petición a la API con tipado fuerte
    const { data: response } = await apiConfig.get<ApiResponse<Alcalde[]>>(
      `/publico/alcaldes?limit=${limit}&offset=${(page - 1) * limit}`,
    );

    // 2. Validar respuesta básica
    if (!response.status || !Array.isArray(response.data)) {
      console.warn('Respuesta API inválida:', response);
      return [];
    }

    // 3. Procesar cada alcalde
    return response.data.map((alcalde) => {
      // Convertir array plan_desarrollo a objeto único (tomamos el primer elemento si existe)
      const planDesarrollo =
        Array.isArray(alcalde.plan_desarrollo) && alcalde.plan_desarrollo.length > 0
          ? alcalde.plan_desarrollo[0]
          : undefined;

      // Procesar documentos si existen
      const planConDocumentos = planDesarrollo
        ? {
            ...planDesarrollo,
            documentos:
              planDesarrollo.documentos?.map((doc: Documento) => ({
                ...doc,
                url: getDocumentUrlAction(doc.path), // Asegurar URL válida
              })) || [], // Fallback a array vacío si no hay documentos
          }
        : undefined;

      return {
        ...alcalde,
        foto_path: getImageAction(alcalde.foto_path),
        plan_desarrollo: planConDocumentos,
      };
    });
  } catch (error) {
    console.error('Error fetching alcaldes:', error);
    throw new Error('Failed to fetch alcaldes data');
  }
};
