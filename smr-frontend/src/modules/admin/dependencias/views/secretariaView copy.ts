import { defineComponent, watch, computed, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import {
  createUpdateSecretaria,
  deleteSecretaria,
  getSecretariaAll,
  getSecretariaById,
} from '../actions';
import CustomInput from '@/modules/admin/components/CustomInput.vue';
import CustomTextArea from '@/modules/admin/components/CustomTextArea.vue';
import CustomInputDate from '@/modules/admin/components/CustomInputDate.vue';
import CustomDocument from '@/modules/admin/components/CustomDocument.vue';
import CustomImagen from '@/modules/admin/components/CustomImagen.vue';

import type { Dependencia, Funcionario, Funciones, Tramite } from '@/modules/interfaces';
import type { ApiError } from '@/modules/interfaces/response';
import { useToast } from 'vue-toast-notification';

const $toast = useToast();

interface FormValues {
  id?: number | null;
  nombre?: string;
  mision?: string;
  vision?: string;
  organigrama?: string;
  created_at?: string;
  updated_at?: string;
  funciones?: Funciones;
  dependencias?: Dependencia;
  tramites?: Tramite;
  funcionarios?: Funcionario;
}

const toSafeDate = (value: unknown): Date | null => {
  if (value instanceof Date) return isNaN(value.getTime()) ? null : value;
  if (typeof value === 'string' || typeof value === 'number') {
    const date = new Date(value);
    return isNaN(date.getTime()) ? null : date;
  }
  return null;
};

// Esquema de validación actualizado
const validationSchema = yup.object({
  nombre: yup.string().required('El nombre de la secretaría es obligatorio'),
  mision: yup.string().required('La misión es obligatoria'),
  vision: yup.string().required('La visión es obligatoria'),
  organigrama: yup.string().required('El organigrama es obligatorio'),

  funciones: yup.object({
    nombre: yup.string().required('El nombre de la función es obligatorio'),
    orden: yup
      .number()
      .typeError('El orden debe ser un número')
      .positive('El orden debe ser mayor a 0')
      .integer('El orden debe ser un número entero')
      .required('El orden es obligatorio'),
  }),

  dependencias: yup.object({
    nombre: yup.string().required('El nombre de la dependencia es obligatorio'),
    descripcion: yup.string().required('La descripción de la dependencia es obligatoria'),
  }),

  tramites: yup.object({
    nombre: yup.string().required('El nombre del trámite es obligatorio'),
    descripcion: yup.string().required('La descripción del trámite es obligatoria'),
  }),

  funcionarios: yup.object({
    nombres: yup.string().required('Los nombres son obligatorios'),
    apellidos: yup.string().required('Los apellidos son obligatorios'),
    cargo: yup.string().required('El cargo es obligatorio'),
    genero: yup
      .string()
      .oneOf(['M', 'F'], 'El género debe ser M o F')
      .required('El género es obligatorio'),
    correo: yup.string().email('El correo debe ser válido').required('El correo es obligatorio'),
    linkendin: yup.string().url('LinkedIn debe ser una URL válida'),
    fecha_ingreso: yup
      .mixed()
      .required('La fecha de ingreso es obligatoria')
      .test('is-valid-date', 'Debe ser una fecha válida', (value) => toSafeDate(value) !== null),
    estado: yup.string().required('El estado es obligatorio'),
  }),
});

// valores iniciales del formulario

export default defineComponent({
  components: {
    CustomInput,
    CustomTextArea,
    CustomInputDate,
    CustomDocument,
    CustomImagen,
  },

  setup() {
    const route = useRoute();
    const router = useRouter();
    const queryClient = useQueryClient();

    const secretariaId = computed(() => Number(route.params.id));
    const API_STORAGE_URL = `${import.meta.env.VITE_API_BASE_URL}/storage`;
    const resetKey = ref(0);

    const { values, defineField, errors, setErrors, handleSubmit, resetForm, setFieldValue } =
      useForm<FormValues>({
        validationSchema,
        initialValues: {
          nombre: '',
          mision: '',
          vision: '',
          organigrama: '',
          funciones: { id: undefined, nombre: '', orden: null },
          dependencias: { id: undefined, nombre: '', descripcion: '' },
          tramites: { id: undefined, nombre: '', descripcion: '' },
          funcionarios: {
            id: undefined,
            nombres: '',
            apellidos: '',
            cargo: '',
            genero: 'M',
            foto: '',
            correo: '',
            linkendin: '',
            fecha_ingreso: '',
            estado: '',
          },
        },
      });

    // Secretaría
    const [nombre, nombreAttrs] = defineField('nombre');
    const [mision, misionAttrs] = defineField('mision');
    const [vision, visionAttrs] = defineField('vision');
    const [organigrama, organigramaAttrs] = defineField('organigrama');

    // Funciones
    const [nombreFunciones, nombreFuncionesAttrs] = defineField('funciones.nombre');
    const [ordenFunciones, ordenFuncionesAttrs] = defineField('funciones.orden');

    // Dependencias
    const [nombreDependencia, nombreDependenciaAttrs] = defineField('dependencias.nombre');
    const [descripcionDependencia, descripcionDependenciaAttrs] = defineField(
      'dependencias.descripcion',
    );

    // Trámites
    const [nombreTramites, nombreTramitesAttrs] = defineField('tramites.nombre');
    const [descripcionTramites, descripcionTramitesAttrs] = defineField('tramites.descripcion');

    // Funcionarios
    const [nombres, nombresAttrs] = defineField('funcionarios.nombres');
    const [apellidos, apellidosAttrs] = defineField('funcionarios.apellidos');
    const [cargo, cargoAttrs] = defineField('funcionarios.cargo');
    const [genero, generoAttrs] = defineField('funcionarios.genero');
    const [correo, correoAttrs] = defineField('funcionarios.correo');
    const [linkendin, linkendinAttrs] = defineField('funcionarios.linkendin');
    const [fecha_ingreso, fecha_ingresoAttrs] = defineField('funcionarios.fecha_ingreso');
    const [estado, estadoAttrs] = defineField('funcionarios.estado');

      const fetchAlcaldes = (page: number = 1, limit: number = 10) => {
      return useQuery({
        queryKey: ['secretaria', page, limit],
        queryFn: () => getSecretariaAll(page, limit),
        staleTime: 30000,
      });
    };

    // Query para obtener datos de la secretaria
    const { data: secretariaData, error: queryError } = useQuery({
      queryKey: ['secretaria', secretariaId.value],
      queryFn: () => getSecretariaById(secretariaId.value),
      enabled: !!secretariaId.value,
      staleTime: 30000,
    });

    watch(queryError, (error) => {
      if (error) {
        $toast.error(error.message || 'Error al cargar los datos');
        console.error('Error loading :', error);
      }
    });

    // Cargar datos en el formulario

    watch(
      () => secretariaData.value,
      (resp) => {
        const secretaria = resp?.data;
        // Verificamos primero la estructura real de los datos

        // Extraemos los datos reales del alcalde de manera segura

        if (!secretaria) {
          $toast.info('Cargando informacion');
          return;
        }

        try {
          // Manejo flexible de funcionarios

          const funcionamiento = Array.isArray(secretaria.funciones)
            ? secretaria.funciones.length > 0
              ? secretaria.funciones[0]
              : null
            : secretaria.funciones;

          const dependencia = Array.isArray(secretaria.dependencias)
            ? secretaria.dependencias.length > 0
              ? secretaria.dependencias[0]
              : null
            : secretaria.dependencias;

          const tramite = Array.isArray(secretaria.tramites)
            ? secretaria.tramites.length > 0
              ? secretaria.tramites[0]
              : null
            : secretaria.tramites;

          const funcionario = Array.isArray(secretaria.funcionarios)
            ? secretaria.funcionarios.length > 0
              ? secretaria.funcionarios[0]
              : null
            : secretaria.funcionarios;

          const valoresFormulario: FormValues = {
            id: secretaria.id,
            nombre: secretaria.nombre || '',
            mision: secretaria.mision || '',
            vision: secretaria.vision || '',
            organigrama: secretaria.organigrama || '',

            funciones: {
              id: funcionamiento?.id,
              nombre: funcionamiento?.nombre,
              orden: funcionamiento?.orden,
              secretaria_id: funcionamiento?.secretaria_id,
            },
            dependencias: {
              id: dependencia?.id,
              nombre: dependencia?.nombre,
              descripcion: dependencia?.descripcion,
              secretaria_id: dependencia?.secretaria_id,
            },
            tramites: {
              id: tramite?.id,
              nombre: tramite?.nombre,
              descripcion: tramite?.descripcion,
              dependencia_id: tramite?.dependencia_id,
              secretaria_id: tramite?.secretaria_id,
            },

            funcionarios: {
              id: funcionario?.id,
              nombres: funcionario?.nombres || undefined,
              apellidos: funcionario?.apellidos || undefined,
              cargo: funcionario?.cargo || undefined,
              genero: funcionario?.genero || undefined,
              foto: funcionario?.foto || undefined,
              correo: funcionario?.correo || undefined,
              linkendin: funcionario?.linkendin || undefined,
              fecha_ingreso: funcionario?.fecha_ingreso || undefined,
              estado: funcionario?.estado || undefined,
            },
          };

          resetForm({
            values: valoresFormulario,
          });

          resetKey.value++;
        } catch (error) {
          console.error('Error al procesar datos :', error);
          $toast.error('Error al cargar los datos ');
        }
      },
      { immediate: true, deep: true },
    );

    return {
      values,
      errors,
      // isPending,
      // fileOrganigrama,
      // fileFoto,
      resetKey,
      nombre,
      nombreAttrs,
      mision,
      misionAttrs,
      vision,
      visionAttrs,
      organigrama,
      organigramaAttrs,
      nombreFunciones,
      nombreFuncionesAttrs,
      ordenFunciones,
      ordenFuncionesAttrs,
      nombreDependencia,
      nombreDependenciaAttrs,
      descripcionDependencia,
      descripcionDependenciaAttrs,
      nombreTramites,
      nombreTramitesAttrs,
      descripcionTramites,
      descripcionTramitesAttrs,
      nombres,
      nombresAttrs,
      apellidos,
      apellidosAttrs,
      cargo,
      cargoAttrs,
      genero,
      generoAttrs,
      correo,
      correoAttrs,
      linkendin,
      linkendinAttrs,
      fecha_ingreso,
      fecha_ingresoAttrs,
      estado,
      estadoAttrs,

      // existingDocuments,
      // removeExistingDocument,
      // onSubmit,
      // eliminarAlcalde,
      // fetchAlcaldes,
    };
  },
});
