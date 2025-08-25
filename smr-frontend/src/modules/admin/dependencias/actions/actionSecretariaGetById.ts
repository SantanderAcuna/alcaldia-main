import { apiConfig } from '@/api/apiConfig';
import type { Secretaria } from '@/modules/interfaces';
import { getImageAction } from './actionSecretariaImagen';
import type { ApiResponse } from '@/modules/interfaces/response';

export const getSecretariaById = async (secretariaId: number): Promise<ApiResponse<Secretaria>> => {
  if (Number.isNaN(secretariaId) || secretariaId === null) {
    return {
      status: false,
      error: { message: 'ID inválido' },
    };
  }

  try {
    const { data } = await apiConfig.get<ApiResponse<Secretaria>>(
      `/admin/secretaria-admin/${secretariaId}`,
    );

    console.log(data);

    // Verificar y asegurar que plan_desarrollo sea un array
    const funcionario = Array.isArray(data.data?.funcionarios) ? data.data?.funcionarios : [];

    // Procesar documentos para cada plan
    const funcionarioProcendo = funcionario.map((fun) => {
      return {
        ...fun,
        foto: getImageAction(fun.foto),
      };
    });

    return {
      status: true,
      data: {
        ...data, // Mantenemos todos los datos originales del alcalde
        organigrama: getImageAction(data.data?.organigrama),
        funcionarios: funcionarioProcendo,
      },
    };
  } catch (error) {
    console.error('Error en getAlcaldeById:', error);
    throw error;
  }
};
