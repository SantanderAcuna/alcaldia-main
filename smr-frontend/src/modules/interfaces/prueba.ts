export interface Alcalde {
  status: boolean;
  data:   Data;
}

export interface Data {
  current_page:   number;
  data:           Datum[];
  first_page_url: string;
  from:           number;
  last_page:      number;
  last_page_url:  string;
  links:          Link[];
  next_page_url:  null;
  path:           string;
  per_page:       number;
  prev_page_url:  null;
  to:             number;
  total:          number;
}

export interface Datum {
  id:              number;
  nombre_completo: string;
  sexo:            string;
  fecha_inicio:    Date;
  fecha_fin:       Date;
  presentacion:    string;
  foto_path:       string;
  actual:          boolean;
  created_at:      Date;
  updated_at:      Date;
  deleted_at:      null;
  plan_desarrollo: PlanDesarrollo[];
}

export interface PlanDesarrollo {
  id:           number;
  alcalde_id:   number;
  titulo:       string;
  descripcion:  string;
  created_at:   Date;
  updated_at:   Date;
  deleted_at:   null;
  document_url: null;
  documentos:   Documento[];
}

export interface Documento {
  id:                    number;
  plan_de_desarrollo_id: number;
  path:                  string;
  nombre:                string;
  created_at:            Date;
  updated_at:            Date;
  deleted_at:            null;
}



export interface Link {
  url:    null | string;
  label:  string;
  active: boolean;
}
