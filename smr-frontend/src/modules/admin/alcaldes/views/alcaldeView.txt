import { defineComponent, watch, computed, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useMutation, useQuery } from '@tanstack/vue-query';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { createUpdateAlcalde, getAlcaldeById } from '../actions';
import CustomInput from '@/modules/admin/components/CustomInput.vue';
import CustomTextArea from '@/modules/admin/components/CustomTextArea.vue';
import CustomInputDate from '@/modules/admin/components/CustomInputDate.vue';
import CustomDocument from '@/modules/admin/components/CustomDocument.vue';
import CustomImagen from '@/modules/admin/components/CustomImagen.vue';

import { useToast } from 'vue-toast-notification';
import type { Documento } from '@/modules/interfaces/documentoInterfaces';
import type { Alcalde } from '@/modules/interfaces/alcaldesInterfaces';

interface ApiError {
  response?: {
    data?: {
      errors?: Record<string, string[]>;
      message?: string;
    };
  };
  message?: string;
}

// type PlanErrors = {
//   titulo?: string;
//   descripcion?: string;
//   documentos?: string;
//   documentos_array?: Array<{ index: number; error: string }>;
// };

// interface FormErrors {
//   plan?: string | PlanErrors;
// }

interface FormValues {
  id?: number | null;
  nombre_completo: string;
  presentacion: string;
  fecha_inicio?: string | null;
  fecha_fin?: string | null;
  sexo: 'masculino' | 'femenino';
  actual: boolean;
  foto_path: string;
  plan?: {
    titulo?: string;
    descripcion?: string;
    documentos?: Array<{
      id?: number;
      nombre: string;
      path: string;
    }>;
  };
}

const $toast = useToast();
const toSafeDate = (value: unknown): Date | null => {
  if (value instanceof Date) return isNaN(value.getTime()) ? null : value;
  if (typeof value === 'string' || typeof value === 'number') {
    const date = new Date(value);
    return isNaN(date.getTime()) ? null : date;
  }
  return null;
};
// Esquema de validación
const validationSchema = yup.object({
  nombre_completo: yup.string().required('Nombre completo es obligatorio'),
  presentacion: yup.string().required('Presentación es obligatoria'),
  // Función utilitaria para manejo seguro de fechas

  // Esquema de validación actualizado
  fecha_inicio: yup
    .mixed()
    .required('Fecha de inicio es obligatoria')
    .test('is-valid-date', 'Debe ser una fecha válida', (value) => {
      return toSafeDate(value) !== null;
    }),
  fecha_fin: yup
    .mixed()
    .required('Fecha de fin es obligatoria')
    .test('is-valid-date', 'Debe ser una fecha válida', (value) => {
      return toSafeDate(value) !== null;
    })
    .test('is-after-start', 'La fecha de fin debe ser posterior a la de inicio', function (value) {
      const { fecha_inicio } = this.parent;

      const startDate = toSafeDate(fecha_inicio);
      const endDate = toSafeDate(value);

      // Caso 1: Fechas inválidas
      if (startDate === null || endDate === null) return false;

      // Caso 2: Fecha fin debe ser posterior
      return endDate > startDate;
    }),
  sexo: yup.string().required('Sexo es obligatorio').oneOf(['masculino', 'femenino']),
  actual: yup.boolean().required('Estado actual es obligatorio').default(false),
  foto_path: yup.mixed().required('La foto es obligatoria'),
  plan: yup.object({
    titulo: yup.string().required('Título del plan es obligatorio'),
    descripcion: yup.string().required('Descripción del plan es obligatoria'),
    documentos: yup
      .array()
      .of(
        yup.object({
          path: yup.string().required('Ruta del documento es obligatoria'),
          nombre: yup.string().required('Nombre del documento es obligatorio'),
        }),
      )
      .min(1, 'Debe adjuntar al menos un documento')
      .required('Los documentos son obligatorios'),
  }),
});

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

    const alcaldeId = computed(() => Number(route.params.id));
    const API_STORAGE_URL = `${import.meta.env.VITE_API_BASE_URL}/storage`;
    const resetKey = ref(0);

    // Configuración del formulario
    const { values, defineField, errors, setErrors, handleSubmit, resetForm, setFieldValue } =
      useForm<FormValues>({
        validationSchema,
        initialValues: {
          id: null,
          nombre_completo: '',
          presentacion: '',
          fecha_inicio: '',
          fecha_fin: '',
          sexo: 'masculino',
          actual: false,
          foto_path: '',
          plan: {
            titulo: '',
            descripcion: '',
            documentos: [],
          },
        },
      });

    // Definición de campos
    const [nombre_completo, nombre_completoAttrs] = defineField('nombre_completo');
    const [presentacion, presentacionAttrs] = defineField('presentacion');
    const [fecha_inicio, fecha_inicioAttrs] = defineField('fecha_inicio');
    const [fecha_fin, fecha_finAttrs] = defineField('fecha_fin');
    const [sexo, sexoAttrs] = defineField('sexo');
    const [actual, actualAttrs] = defineField('actual');
    const [fotoPath, fotoPathAttrs] = defineField('foto_path');
    const [titulo, tituloAttrs] = defineField('plan.titulo');
    const [descripcion, descripcionAttrs] = defineField('plan.descripcion');
    const [documentos, documentPathAttrs] = defineField('plan.documentos');

    // Query para obtener datos del alcalde
    const { data: alcaldeData } = useQuery({
      queryKey: ['alcalde', alcaldeId.value],
      queryFn: () => getAlcaldeById(alcaldeId.value),
      enabled: !!alcaldeId.value,
      staleTime: 30000,
    });

    // Mutation para crear/actualizar
    const { mutate, isPending } = useMutation({
      mutationFn: createUpdateAlcalde,
      onSuccess: () => {
        router.push('/admin/alcaldes');
        $toast.success('Alcalde guardado exitosamente');
      },
      onError: (error: ApiError) => {
        if (error.response?.data?.errors) {
          setErrors(error.response.data.errors);
        }
        $toast.error(error.message || 'Error al guardar el alcalde');
      },
    });

    // Cargar datos en el formulario
    watch(
      () => alcaldeData.value,
      (response: Alcalde | undefined) => {
        if (!response) return;

        const plan = response.plan_desarrollo || null;

        // Mantener fechas como strings o null
        const fechaFin = response.fecha_fin || null;
        const fechaInicio = response.fecha_inicio || null;

        resetForm({
          values: {
            ...response,
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin,
            plan: {
              titulo: plan?.titulo || '',
              descripcion: plan?.descripcion || '',
              documentos:
                plan?.documentos?.map((doc: Documento) => ({
                  id: doc.id ?? undefined,
                  path: doc.path,
                  nombre: doc.nombre,
                })) || [],
            },
          },
        });

        resetKey.value++;
      },
      { immediate: true },
    );

    // Documentos existentes
    const existingDocuments = computed(() => {
      return (values.plan?.documentos || [])
        .filter((doc): doc is { id: number; nombre: string; path: string } => !!doc.id)
        .map((doc) => ({
          id: doc.id,
          nombre: doc.nombre,
          path: doc.path,
        }));
    });

    // Eliminar documento existente
    const removeExistingDocument = (id: number) => {
      const updatedDocs = values.plan?.documentos?.filter((doc) => doc.id !== id) || [];
      setFieldValue('plan.documentos', updatedDocs);
      resetKey.value++;
    };

    // Actualizar la firma de la función
    const formatDateForSubmit = (date: string | null | undefined): string => {
      if (!date) return '';

      try {
        const parsedDate = new Date(date);
        return isNaN(parsedDate.getTime()) ? '' : parsedDate.toISOString().split('T')[0];
      } catch {
        return '';
      }
    };

    // Envío del formulario
    const onSubmit = handleSubmit(async (formValues) => {
      const formattedStartDate = formatDateForSubmit(formValues.fecha_inicio);
      const formattedEndDate = formatDateForSubmit(formValues.fecha_fin);

      if (!formattedStartDate || !formattedEndDate) {
        $toast.error('Las fechas son requeridas y deben ser válidas');
        return;
      }

      const formData = new FormData();

      // Campos básicos
      formData.append('nombre_completo', formValues.nombre_completo);
      formData.append('presentacion', formValues.presentacion);
      formData.append('fecha_inicio', formattedStartDate);
      formData.append('fecha_fin', formattedEndDate);
      formData.append('sexo', formValues.sexo);
      formData.append('actual', formValues.actual ? '1' : '0');

      if (!formValues.plan?.titulo) {
        throw new Error('Plan de desarrollo es requerido');
      }
      formData.append('plan[titulo]', formValues.plan.titulo);

      if (!formValues.plan?.descripcion) {
        throw new Error('Plan de desarrollo es requerido');
      }

      formData.append('plan[descripcion]', formValues.plan.descripcion);

      if (!formValues.plan?.documentos) {
        throw new Error('Plan de desarrollo es requerido');
      }

      // Verificar y usar optional chaining con array vacío como fallback
      const documentos = formValues.plan.documentos ?? [];

      documentos.forEach((doc, index) => {
        // Verificar documento válido
        if (!doc || !doc.path || !doc.nombre) return;

        if (doc.id) {
          formData.append(`plan[documentos][${index}][id]`, doc.id.toString());
        }

        formData.append(`plan[documentos][${index}][path]`, doc.path);
        formData.append(`plan[documentos][${index}][nombre]`, doc.nombre);
      });

      // ID para actualización
      if (formValues.id) {
        formData.append('id', formValues.id.toString());
        formData.append('_method', 'PATCH');
      }

      // Foto - verificación segura de tipos
      if (isFile(formValues.foto_path)) {
        formData.append('foto', formValues.foto_path);
      } else if (isFilePath(formValues.foto_path)) {
        formData.append('foto_path', formValues.foto_path);
      }

      mutate(formData);
    });

    // Función de tipo guarda para verificar si es File
    const isFile = (value: unknown): value is File => {
      return typeof value === 'object' && value !== null && value instanceof File;
    };

    // Función para verificar si es string de ruta válida
    const isFilePath = (value: unknown): value is string => {
      return typeof value === 'string' && value.trim() !== '';
    };

    // URLs para visualización
    // URLs para visualización
    const filePaths = computed(() => ({
      photo: isFile(values.foto_path)
        ? URL.createObjectURL(values.foto_path)
        : isFilePath(values.foto_path)
          ? `${API_STORAGE_URL}/${values.foto_path}`
          : null,
    }));

    return {
      values,
      errors,
      isPending,
      filePaths,
      resetKey,
      nombre_completo,
      nombre_completoAttrs,
      presentacion,
      presentacionAttrs,
      fecha_inicio,
      fecha_inicioAttrs,
      fecha_fin,
      fecha_finAttrs,
      sexo,
      sexoAttrs,
      actual,
      actualAttrs,
      fotoPath,
      fotoPathAttrs,
      titulo,
      tituloAttrs,
      descripcion,
      descripcionAttrs,
      documentos,
      documentPathAttrs,
      existingDocuments,

      removeExistingDocument,

      onSubmit,
      // eliminarAlcalde,
      // deleteAlcalde,
    };
  },
});
