import { apiConfig } from '@/api/apiConfig';

// import type { Alcaldes } from '../interfaces/alcaldesInterfaces';
import type { Alcaldes } from '@/modules/interfaces/alcaldesInterfaces';
import { getImageAction } from './getImageAdminAction';
import { getDocumentUrlAction } from './getDocumenAdmintActions';

// Define la interfaz de la respuesta completa
interface ApiResponse {
  status: boolean;
  data: Alcaldes[];
}

export const getAlcaldeActions = async (page: number = 1, limit: number = 1) => {
  try {
    // 1. Usa la interfaz ApiResponse
    const { data: response } = await apiConfig.get<ApiResponse>(
      `/publico/alcaldes?limit=${limit}&offset=${page * limit}`,
    );

    // 2. Accede al array correcto (response.data)
    const alcaldesData = response.data;

    return alcaldesData.map((alcalde) => ({
      ...alcalde,
      foto_path: getImageAction(alcalde.foto_path),
      plan_desarrollo: {
        ...alcalde.plan_desarrollo,
        document_url: getDocumentUrlAction(alcalde.plan_desarrollo.document_path),
      },
    }));
  } catch (error) {
    console.log(error);
    throw new Error(`${error}`);
  }
};
