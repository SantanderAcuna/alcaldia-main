import { apiConfig } from '@/api/apiConfig';
import type { Alcaldes } from '@/modules/interfaces/alcaldesInterfaces';
import { getImageAction } from './getImageAdminAction';
import { getDocumentUrlAction } from './getDocumenAdmintActions';

export const getAlcaldeById = async (alcaldeId: number): Promise<Alcaldes> => {
  if (Number.isNaN(alcaldeId) || alcaldeId === null) {
    return {
      id: NaN,
      nombre_completo: '',
      sexo: '',
      fecha_inicio: null as unknown as Date,
      fecha_fin: null as unknown as Date,
      presentacion: '',
      foto_path: '',
      actual: false,

      plan_desarrollo: {} as any,
    };
  }

  try {
    const { data } = await apiConfig.get<Alcaldes>(`/publico/alcaldes/${alcaldeId}`);

   

    // Verificar y asegurar que plan_desarrollo sea un array
    const planesDesarrollo = Array.isArray(data.plan_desarrollo) ? data.plan_desarrollo : [];

    // Procesar documentos para cada plan
    const planesProcesados = planesDesarrollo.map((plan) => {
      return {
        ...plan,

        documentos: getDocumentUrlAction(plan.documentos?.map((doc) => doc.path) ?? []),
      };
    });

    return {
      ...data, // Mantenemos todos los datos originales del alcalde
      foto_path: getImageAction(data.foto_path),
      plan_desarrollo: planesProcesados, // Asignamos los planes procesados
    };
  } catch (error) {
    console.error('Error en getAlcaldeById:', error);
    throw error;
  }
};
