/* eslint-disable @typescript-eslint/no-unused-vars */
import { defineComponent, watch, computed, ref, onUnmounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useMutation, useQuery } from '@tanstack/vue-query';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { createUpdateAlcalde, getAlcaldeById } from '../actions';
import CustomInput from '@/modules/helpers/CustomInput.vue';
import CustomTextArea from '@/modules/helpers/CustomTextArea.vue';
import CustomInputDate from '@/modules/helpers/CustomInputDate.vue';
import parseApiDate from '@/config/parseApiDate';
import { useToast } from 'vue-toastification';

// Constantes para validación de fechas

// Esquema de validación
const validationSchema = yup.object({
  nombre_completo: yup.string().required('Nombre completo es obligatorio'),
  presentacion: yup.string().required('Presentación es obligatoria'),
  fecha_inicio: yup.date().required('Fecha de inicio es obligatoria'),
  fecha_fin: yup
    .date()
    .required('Fecha de fin es obligatoria')
    .min(yup.ref('fecha_inicio'), 'Debe ser posterior a inicio'),
  sexo: yup.string().required('Sexo es obligatorio').oneOf(['masculino', 'femenino']),
  actual: yup
    .boolean()
    .default(false) // ⬅️ valor por defecto
    .transform((value, original) => {
      if (original === 'true') return true;
      if (original === 'false') return false;
      return value;
    })
    .required('Estado actual es obligatorio'),

  foto_path: yup.mixed().optional(),

  plan_desarrollo: yup.object({
    titulo: yup.string().required('Título es obligatorio'),
    descripcion: yup.string().required('Descripción es obligatoria'),
    document_path: yup.mixed().optional(),
  }),
});

export default defineComponent({
  components: {
    CustomInput,
    CustomTextArea,
    CustomInputDate,
  },

  props: {
     initialData: { type: Object, default: () => ({}) },
      isEditing: { type: Boolean, default: false },
  },

  setup(props) {
    const route = useRoute();
    const router = useRouter();
    const alcaldeId = computed(() => Number(route.params.id));

    // Referencias para archivos
    const newPhotoFile = ref<File | null>(null);
    const newDocumentFile = ref<File | null>(null);
    const tempPhotoUrl = ref<string | null>(null);
    const selectedPdfName = ref<string>('');

    // Configuración API
    const API_BASE_URL = import.meta.env.VITE_API_BASE_URL ?? '';
    const API_STORAGE_URL = `${API_BASE_URL}/storage`;

    const toast = useToast();

    // Query para obtener alcalde
    const {
      data: alcaldeData,
      refetch,
      isError,
      error,
      isFetching,
    } = useQuery({
      queryKey: ['alcalde', alcaldeId.value],
      queryFn: () => getAlcaldeById(alcaldeId.value),
      retry: false,

      staleTime: 30000,
    });

    // Configuración del formulario
    const { values, defineField, errors, handleSubmit, resetForm, meta } = useForm({
      validationSchema,
    });

    // Definición de campos con sus atributos
    const [nombre_completo, nombre_completoAttrs] = defineField('nombre_completo');
    const [presentacion, presentacionAttrs] = defineField('presentacion');
    const [actual, actualAttrs] = defineField('actual');
    const [fecha_inicio, fecha_inicioAttrs] = defineField('fecha_inicio');
    const [fecha_fin, fecha_finAttrs] = defineField('fecha_fin');
    const [sexo, sexoAttrs] = defineField('sexo');
    const [titulo, tituloAttrs] = defineField('plan_desarrollo.titulo');
    const [descripcion, descripcionAttrs] = defineField('plan_desarrollo.descripcion');
    const [fotoPath, fotoPathAttrs] = defineField('foto_path');
    const [documentPath, documentPathAttrs] = defineField('plan_desarrollo.document_path');

    const {
      mutate,

      isPending,
      isSuccess: isUpdateSuccess,
      data: updateAlcalde,
    } = useMutation({
      mutationFn: createUpdateAlcalde,
    });

    watch(
      () => alcaldeId.value,
      (id) => {
        if (isNaN(id) || id <= 0) {
          resetForm({ values: alcaldeData }); // queda en blanco
        }
      },
      { immediate: true },
    );

    // Sincronizar datos de la API al formulario
    watch(
      alcaldeData,

      (response) => {
        if (isFetching.value || !response?.data) return;

        const alcalde = response.data;
        window.scrollTo({ top: 0, behavior: 'smooth' });

        resetForm({
          values: {
            ...alcalde,

            fecha_inicio: parseApiDate(alcalde.fecha_inicio),
            fecha_fin: parseApiDate(alcalde.fecha_fin),
            plan_desarrollo: {
              titulo: alcalde.plan_desarrollo?.titulo ?? '',
              descripcion: alcalde.plan_desarrollo?.descripcion ?? '',
              document_path: alcalde.plan_desarrollo?.document_path ?? '',
            },
          },
        });
      },
      { immediate: true },
    );

    // Redirección en caso de error

    watch(
      [isError, error],
      ([hasError, err]) => {
        if (hasError && err) {
          console.error('Error cargando alcalde:', err);
          router.replace('/admin/alcaldes');
        }
      },
      { immediate: true },
    );
    // Helpers para UI
    const formattedDates = computed(() => ({
      start: values.fecha_inicio
        ? new Date(values.fecha_inicio).toLocaleDateString('es-CO')
        : 'N/A',
      end: values.fecha_fin ? new Date(values.fecha_fin).toLocaleDateString('es-CO') : 'N/A',
    }));

    const filePaths = computed(() => ({
      photo:
        tempPhotoUrl.value || (values.foto_path ? `${API_STORAGE_URL}/${values.foto_path}` : ''),
      document: values.plan_desarrollo?.document_path
        ? `${API_STORAGE_URL}/${values.plan_desarrollo.document_path}`
        : '',
    }));

    const documentLinkText = computed(
      () =>
        selectedPdfName.value ||
        (values.plan_desarrollo?.document_path?.split('/').pop() ?? 'Ver documento'),
    );

    // Manejadores de archivos
    const onImageSelected = (e: Event) => {
      const input = e.target as HTMLInputElement;
      if (!input.files?.length) return;
      newPhotoFile.value = input.files[0];
      tempPhotoUrl.value = URL.createObjectURL(newPhotoFile.value);
    };

    const onPdfSelected = (e: Event) => {
      const input = e.target as HTMLInputElement;
      if (!input.files?.length) return;
      newDocumentFile.value = input.files[0];
      selectedPdfName.value = input.files[0].name;
    };

    const onSumit = handleSubmit(async (value) => {
      try {
        const formData = new FormData();

        // 1. Campos principales
        formData.append('nombre_completo', value.nombre_completo);
        formData.append('presentacion', value.presentacion);

        // Formatear fechas correctamente para Laravel
        formData.append('fecha_inicio', formatDateForBackend(value.fecha_inicio));
        formData.append('fecha_fin', formatDateForBackend(value.fecha_fin));

        formData.append('sexo', value.sexo);
        formData.append('actual', value.actual ? '1' : '0');

        // 2. Campos de plan_desarrollo
        formData.append('titulo', value.plan_desarrollo.titulo);
        formData.append('descripcion', value.plan_desarrollo.descripcion);

        // 3. ID para actualización
        if (value.id) {
          formData.append('id', value.id.toString());
        }

        // 4. Manejo de archivos (solo si hay cambios)
        if (newPhotoFile.value) {
          formData.append('foto_path', newPhotoFile.value);
        } else if (value.foto_path && !value.foto_path.startsWith('http')) {
          // Solo enviar ruta si no es una URL completa
          formData.append('foto_path_existente', value.foto_path);
        }

        if (newDocumentFile.value) {
          formData.append('document_path', newDocumentFile.value);
        } else if (
          value.plan_desarrollo?.document_path &&
          !value.plan_desarrollo.document_path.startsWith('http')
        ) {
          formData.append('document_path_existente', value.plan_desarrollo.document_path);
        }

        // 5. Debug: Verificar datos
        console.log('Datos enviados al backend:');
        for (const [key, val] of formData.entries()) {
          console.log(`${key}:`, val);
        }

        // 6. Enviar datos
        const alcalde = await createUpdateAlcalde(formData);

        alert('Alcalde actualizado correctamente');

        // 7. Redireccionar
        // router.push('/admin/alcaldes');
      } catch (error) {
        console.error('Error en el formulario:', error);
        // Mostrar errores específicos
        if (
          typeof error === 'object' &&
          error !== null &&
          'message' in error &&
          typeof (error as { message?: unknown }).message === 'string'
        ) {
          const errMsg = (error as { message: string }).message;
          if (errMsg.includes('Error de validación')) {
            alert(`Errores de validación:\n${errMsg.split(': ')[1]}`);
          } else {
            alert(errMsg || 'Error al guardar los datos');
          }
        } else {
          alert('Error al guardar los datos');
        }
      }
    });

    watch(
      isUpdateSuccess,
      (value) => {
        if (!value) return;

        window.scrollTo({ top: 0, behavior: 'smooth' });

        alert('Producto actualizado correctamente');

        resetForm({
          values: updateAlcalde.value,
        });
      },
      { immediate: true },
    );

    // Función auxiliar para formatear fechas
    function formatDateForBackend(date: Date | string): string {
      if (typeof date === 'string') {
        date = new Date(date);
      }
      return date.toISOString().split('T')[0]; // Formato YYYY-MM-DD
    }



    // Limpieza
    onUnmounted(() => {
      if (tempPhotoUrl.value) URL.revokeObjectURL(tempPhotoUrl.value);
    });

    return {
      // Estado
      values,
      errors,
      meta,
      formattedDates,
      filePaths,
      selectedPdfName,
      documentLinkText,
      isFetching,

      // Campos y atributos (necesarios para v-bind)
      nombre_completo,
      nombre_completoAttrs,
      presentacion,
      presentacionAttrs,
      actual,
      actualAttrs,
      fecha_inicio,
      fecha_inicioAttrs,
      fecha_fin,
      fecha_finAttrs,
      sexo,
      sexoAttrs,
      titulo,
      tituloAttrs,
      descripcion,
      descripcionAttrs,
      fotoPath,
      fotoPathAttrs,
      documentPath,
      documentPathAttrs,

      mutate,
      isPending,

      // Métodos
      onSumit, // Nombre corregido para coincidir con el template
      onImageSelected,
      onPdfSelected,
    };
  },
});
