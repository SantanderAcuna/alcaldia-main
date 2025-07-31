import { defineComponent, watch, computed, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useMutation, useQuery } from '@tanstack/vue-query';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { createUpdateAlcalde, getAlcaldeById } from '../actions';
import CustomInput from '@/modules/helpers/CustomInput.vue';
import CustomTextArea from '@/modules/helpers/CustomTextArea.vue';
import CustomInputDate from '@/modules/helpers/CustomInputDate.vue';
import CustomDocument from '@/modules/helpers/CustomDocument.vue';
import CustomImagen from '@/modules/helpers/CustomImagen.vue';

import type { Documento } from '@/modules/interfaces/alcaldesInterfaces';

import { useToast } from 'vue-toast-notification';

const $toast = useToast();

// Esquema de validación
const validationSchema = yup.object({
  nombre_completo: yup.string().required('Nombre completo es obligatorio'),
  presentacion: yup.string().required('Presentación es obligatoria'),
  fecha_inicio: yup
    .mixed()
    .required('Fecha de inicio es obligatoria')
    .test('is-valid-date', 'Debe ser una fecha válida', (value) => {
      if (!value) return false;
      if (value instanceof Date) return !isNaN(value.getTime());
      if (typeof value === 'string') return !isNaN(new Date(value).getTime());
      return false;
    }),
  fecha_fin: yup
    .mixed()
    .required('Fecha de fin es obligatoria')
    .test('is-valid-date', 'Debe ser una fecha válida', (value) => {
      if (!value) return false;
      if (value instanceof Date) return !isNaN(value.getTime());
      if (typeof value === 'string') return !isNaN(new Date(value).getTime());
      return false;
    })
    .test('is-after-start', 'La fecha de fin debe ser posterior a la de inicio', function (value) {
      const { fecha_inicio } = this.parent;
      if (!fecha_inicio || !value) return true;

      const startDate = fecha_inicio instanceof Date ? fecha_inicio : new Date(fecha_inicio);
      const endDate = value instanceof Date ? value : new Date(value);

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
    const { values, defineField, errors, handleSubmit, resetForm, setFieldValue } = useForm({
      validationSchema,
      initialValues: {
        nombre_completo: '',
        presentacion: '',
        fecha_inicio: null,
        fecha_fin: null,
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
      onError: (error: any) => {
        if (error.response?.data?.errors) {
          setErrors(error.response.data.errors);
        }
        $toast.error(error.message || 'Error al guardar el alcalde');
      },
    });

    // Cargar datos en el formulario
    watch(
      alcaldeData,
      (response) => {
        if (!response?.data) return;

        const alcalde = response.data;
        const plan = alcalde.plan_desarrollo?.[0] || null;

        resetForm({
          values: {
            ...alcalde,
            fecha_inicio: alcalde.fecha_inicio ? new Date(alcalde.fecha_inicio) : null,
            fecha_fin: alcalde.fecha_fin ? new Date(alcalde.fecha_fin) : null,
            plan: {
              titulo: plan?.titulo || '',
              descripcion: plan?.descripcion || '',
              documentos:
                plan?.documentos?.map((doc: Documento) => ({
                  id: doc.id,
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

    // Función para manejar el formato de fecha
    const formatDateForSubmit = (date: Date | string | null): string => {
      if (!date) return '';
      if (date instanceof Date) return date.toISOString().split('T')[0];
      if (typeof date === 'string') {
        const parsedDate = new Date(date);
        return isNaN(parsedDate.getTime()) ? '' : parsedDate.toISOString().split('T')[0];
      }
      return '';
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

      // Plan de desarrollo (usando 'plan' en lugar de 'plan_desarrollo')
      formData.append('plan[titulo]', formValues.plan.titulo);
      formData.append('plan[descripcion]', formValues.plan.descripcion);

      // Documentos (también usando 'plan')
      formValues.plan.documentos.forEach((doc: any, index: number) => {
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

      // Foto
      if (formValues.foto_path instanceof File) {
        formData.append('foto', formValues.foto_path);
      } else if (formValues.foto_path) {
        formData.append('foto_path', formValues.foto_path);
      }

      mutate(formData);
    });

    // URLs para visualización
    const filePaths = computed(() => ({
      photo:
        values.foto_path instanceof File
          ? URL.createObjectURL(values.foto_path)
          : values.foto_path
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
