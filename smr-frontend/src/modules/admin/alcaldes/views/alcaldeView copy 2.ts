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
import { useToast } from 'vue-toastification';
import type { Alcaldes } from '@/modules/interfaces/alcaldesInterfaces';

const validationSchema = yup.object({
  nombre_completo: yup.string().required('Nombre completo es obligatorio'),
  presentacion: yup.string().required('Presentación es obligatoria'),
  fecha_inicio: yup
    .date()
    .required('Fecha de inicio es obligatoria')
    .typeError('Debe ser una fecha válida'),
  fecha_fin: yup
    .date()
    .required('Fecha de fin es obligatoria')
    .min(yup.ref('fecha_inicio'), 'La fecha de fin debe ser posterior a la de inicio')
    .typeError('Debe ser una fecha válida'),
  sexo: yup.string().required('Sexo es obligatorio').oneOf(['masculino', 'femenino']),
  actual: yup.boolean().required('Estado actual es obligatorio').default(false),
  foto_path: yup.string().required('La foto es obligatoria'),
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
    const toast = useToast();
    const alcaldeId = computed(() => Number(route.params.id));
    const API_STORAGE_URL = `${import.meta.env.VITE_API_BASE_URL}/storage`;
    const resetKey = ref(0);

    // Configuración del formulario
    const { values, defineField, errors, handleSubmit, resetForm, setFieldValue } =
      useForm<Alcaldes>({
        validationSchema,
        initialValues: {
          plan_desarrollo: {
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
        toast.success('Alcalde guardado exitosamente');
        router.push('/admin/alcaldes');
      },
      onError: (error) => {
        toast.error(error.message || 'Error al guardar el alcalde');
      },
    });

    // Cargar datos en el formulario
    watch(
      alcaldeData,
      (response) => {
        if (!response?.data) return;

        const { data: alcalde } = response;
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
                plan?.documentos?.map((doc) => ({
                  id: doc.id,
                  path: doc.path,
                  nombre: doc.nombre,
                })) || [],
            },
          },
        });

        // Incrementar resetKey para forzar reinicio de componentes
        resetKey.value++;
      },
      { immediate: true },
    );

    // Documentos existentes para CustomDocument
    const existingDocuments = computed(() => {
      return (values.plan?.documentos || [])
        .filter((doc) => doc.id)
        .map((doc) => ({
          id: doc.id as number,
          nombre: doc.nombre,
          path: doc.path,
        }));
    });

    // Eliminar documento existente
    const removeExistingDocument = (id: number) => {
      const updatedDocs = values.plan?.documentos?.filter((doc) => doc.id !== id) || [];
      setFieldValue('plan.documentos', updatedDocs);
      resetKey.value++; // Forzar actualización del componente
    };

    // Envío del formulario
    const onSubmit = handleSubmit(async (formValues) => {
      const formData = new FormData();

      // Campos básicos
      formData.append('nombre_completo', formValues.nombre_completo);
      formData.append('presentacion', formValues.presentacion);
      formData.append('fecha_inicio', formValues.fecha_inicio.toISOString().split('T')[0]);
      formData.append('fecha_fin', formValues.fecha_fin.toISOString().split('T')[0]);
      formData.append('sexo', formValues.sexo);
      formData.append('actual', formValues.actual ? '1' : '0');

      // Plan de desarrollo
      formData.append('plan[titulo]', formValues.plan.titulo);
      formData.append('plan[descripcion]', formValues.plan.descripcion);

      // Documentos
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

      // Foto (manejada por CustomImagen)
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
      // Estado
      values,
      errors,
      isPending,
      filePaths,
      resetKey,

      // Campos y atributos
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

      // Métodos
      onSubmit,
      removeExistingDocument,
      existingDocuments,
    };
  },
});
