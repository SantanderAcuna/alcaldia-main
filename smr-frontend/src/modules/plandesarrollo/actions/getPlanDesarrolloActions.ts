import { apiConfig } from '@/api/apiConfig';

import type { PlanDesarrollo } from '@/modules/interfaces/planDesarrollointerfaces';
import { getDocumentUrlAction } from './getDocumentActions';
// import getImageAction  from '@/modules/plandesarrollo/actions/index';

// Define la interfaz de la respuesta completa
interface ApiResponse {
  status: boolean;
  data: PlanDesarrollo[];
}

export const getPlanDesarrolloActions = async (page: number = 1, limit: number = 10) => {
  try {
    const { data: response } = await apiConfig.get<ApiResponse>(
      `/plan?limit=${limit}&offset=${page * limit}`,
    );

    const planesData = response.data;

    return planesData.map((plan) => ({
      ...plan,
      document_url: getDocumentUrlAction(plan.document_path),
    }));

    // return planesData;
  } catch (error) {
    console.log(error);
    throw new Error(`${error}`);
  }
};
