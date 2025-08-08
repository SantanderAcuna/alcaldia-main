// En tu archivo ../actions.ts (o donde tengas las acciones)
import { apiConfig } from '@/api/apiConfig';
import axios from 'axios';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

// Interfaz para el tipo Alcalde
export interface Alcalde {
  id?: number;
  nombre_completo: string;
  presentacion: string;
  fecha_inicio?: string | null;
  fecha_fin?: string | null;
  sexo: 'masculino' | 'femenino';
  actual: boolean;
  foto_path: string;
  plan_desarrollo?: {
    titulo?: string;
    descripcion?: string;
    documentos?: Array<{
      id?: number;
      nombre: string;
      path: string;
    }>;
  };
}

// Obtener lista de alcaldes
export const getAlcaldesList = async (): Promise<Alcalde[]> => {
  const response = await apiConfig.get(`${API_BASE_URL}/alcaldes`);
  return response.data.data;
};

// Obtener alcalde por ID
export const getAlcaldeById = async (id: number): Promise<Alcalde> => {
  const response = await axios.get(`${API_BASE_URL}/alcaldes/${id}`);
  return response.data.data;
};

// Crear o actualizar alcalde
// En peticiones.actions.ts
export const createUpdateAlcalde = async (formData: FormData): Promise<Alcalde> => {
  try {
    // Extraemos el id si existe
    const id = formData.get('id');

    // Configuramos la URL y método según si es creación o actualización
    const url = id ? `${API_BASE_URL}/alcaldes/${id}` : `${API_BASE_URL}/alcaldes`;

    const method = id ? 'PUT' : 'POST';

    // Realizamos la petición
    const response = await axios({
      method,
      url,
      data: formData,
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    return response.data.data;
  } catch (error) {
    console.error('Error en createUpdateAlcalde:', error);
    throw error;
  }
};

// Eliminar alcalde
export const deleteAlcalde = async (id: number): Promise<void> => {
  await axios.delete(`${API_BASE_URL}/alcaldes/${id}`);
};
