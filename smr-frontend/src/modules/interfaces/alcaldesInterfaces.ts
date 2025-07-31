export interface Alcaldes {
  id?: number | null;
  nombre_completo: string;
  presentacion: string;
  fecha_inicio: Date | string | null;
  fecha_fin: Date | string | null;
  sexo: 'masculino' | 'femenino';
  actual: boolean;
  foto_path: string | File;

  plan_desarrollo: {
    id?: number | null;
    titulo: string;
    descripcion: string;

    documentos: Array<{
      id?: number | null;
      path: string;
      nombre: string;
    }>;
  };
}

export interface PlanDesarrollo {
  id: number;
  alcalde_id: number;
  titulo: string;
  descripcion: string;
  documentos: Documento[];
}

export interface Documento {
  id?: number;
  plan_de_desarrollo_id?: number;
  path: string;
  nombre: string;
}
