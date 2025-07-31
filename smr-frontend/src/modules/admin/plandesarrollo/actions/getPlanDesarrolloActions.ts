import { apiConfig } from '@/api/apiConfig';

import type { PlanDesarrollo } from '@/modules/interfaces/planDesarrollointerfaces';
import { getDocumentUrlAction } from './getDocumentActions';

interface ApiResponse {
  status: boolean;
  data: PlanDesarrollo[];
}

/**
 * Obtiene planes de desarrollo paginados.
 * @param page  – Página 1-based (frontend friendly)
 * @param limit – Registros por página
 */
export const getPlanDesarrolloActions = async (page = 1, limit = 10): Promise<PlanDesarrollo[]> => {
  const offset = (page - 1) * limit; // ← cálculo estándar de paginación

  const { data: response } = await apiConfig.get<ApiResponse>(
    `/publico/plan?limit=${limit}&offset=${offset}`,
  );

  // Sanidad: si la API fallara silenciosamente
  if (!response.status || !Array.isArray(response.data)) return [];

  /* ----------------------------------------------------------------
   *  Normalizamos cada registro (inmutable).
   * ---------------------------------------------------------------- */
  return response.data.map((plan) => ({
    ...plan,
    document_url: getDocumentUrlAction(plan.document_path),
  }));
};
