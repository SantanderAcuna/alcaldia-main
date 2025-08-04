import { apiConfig } from '@/api/apiConfig';
import type { Alcalde } from '@/modules/interfaces/alcaldesInterfaces';
import { getImageAction } from './getImageAdminAction';
import { getDocumentUrlAction } from './getDocumenAdmintActions';
import type { Documento } from '@/modules/interfaces/documentoInterfaces';

export const getAlcaldeById = async (alcaldeId: number): Promise<Alcalde> => {
  if (Number.isNaN(alcaldeId) || alcaldeId === null) {
    return {
      id: NaN,
      nombre_completo: '',
      sexo: 'masculino',
      fecha_inicio: '',
      fecha_fin: '',
      presentacion: '',
      foto_path: '',
      actual: false,

      plan_desarrollo: {} as any,
    };
  }

  try {
    const { data } = await apiConfig.get<Alcalde>(`/publico/alcaldes/${alcaldeId}`);

    // Verificar y asegurar que plan_desarrollo sea un array
    const planesDesarrollo = Array.isArray(data.plan_desarrollo) ? data.plan_desarrollo : [];

    // Procesar documentos para cada plan
    const planesProcesados = planesDesarrollo.map((plan) => {
      return {
        ...plan,

        documentos: getDocumentUrlAction(plan.documentos?.map((doc: Documento) => doc.path) ?? []),
      };
    });

    return {
      ...data, // Mantenemos todos los datos originales del alcalde
      foto_path: getImageAction(data.foto_path),
      plan_desarrollo: planesProcesados[0] || null,
    };
  } catch (error) {
    console.error('Error en getAlcaldeById:', error);
    throw error;
  }
};
