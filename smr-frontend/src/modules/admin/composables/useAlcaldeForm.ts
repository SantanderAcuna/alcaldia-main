// src/composables/useAlcaldeForm.ts
import { ref, computed, onUnmounted, watch } from 'vue';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import { createUpdateAlcalde, getAlcaldeById } from '@/api/alcaldes';
import { formatDateForBackend, parseApiDate } from '@/modules/admin/utils/dateUtils';
import { useQuery } from '@tanstack/vue-query';

console.log('[useAlcaldeForm] Inicializando composable...');
console.log('[useAlcaldeForm] isEditing:');
console.log('[useAlcaldeForm] initialData:');

interface PlanDesarrollo {
  titulo: string;
  descripcion: string;
  document_path?: string;
}

interface AlcaldeData {
  id: number;
  nombre_completo: string;
  presentacion: string;
  fecha_inicio: string | Date;
  fecha_fin: string | Date;
  sexo: 'masculino' | 'femenino';
  actual: boolean;
  foto_path?: string;
  plan_desarrollo?: PlanDesarrollo;
}

export function useAlcaldeForm(initialData: Partial<AlcaldeData>, isEditing: boolean) {
  const router = useRouter();
  const toast = useToast();
  const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
  const showDebug = import.meta.env.DEV;

  console.log('[useAlcaldeForm] API_BASE_URL:', API_BASE_URL);

  // Referencias para archivos
  const newPhotoFile = ref<File | null>(null);
  const newDocumentFile = ref<File | null>(null);
  const tempPhotoUrl = ref<string | null>(null);
  const selectedPdfName = ref('');
  const isPending = ref(false);

  console.log('[useAlcaldeForm] Creando esquema de validación...');
  // Esquema de validación - CORREGIDO
  const validationSchema = yup.object({
    id: yup.number().optional(),
    nombre_completo: yup.string().required('Nombre completo es obligatorio'),
    presentacion: yup.string().required('Presentación es obligatoria'),
    fecha_inicio: yup
      .mixed()
      .test('is-date', 'Fecha de inicio es obligatoria', (value) => {
        console.log('[Validación fecha_inicio] Valor:', value, 'Tipo:', typeof value);
        return value instanceof Date;
      })
      .required('Fecha de inicio es obligatoria'),
    fecha_fin: yup
      .mixed()
      .test('is-date', 'Fecha de fin es obligatoria', (value) => {
        console.log('[Validación fecha_fin] Valor:', value, 'Tipo:', typeof value);
        return value instanceof Date;
      })
      .required('Fecha de fin es obligatoria')
      .test(
        'is-after-start',
        'Debe ser posterior a inicio',
        function (value) {
          const startDate = this.parent.fecha_inicio;
          console.log('[Validación fechas] Inicio:', startDate, 'Fin:', value);
          return value > startDate;
        }
      ),
    sexo: yup.string().required('Sexo es obligatorio').oneOf(['masculino', 'femenino']),
    actual: yup
      .boolean()
      .default(false)
      .transform((value, original) => {
        console.log('[Transformación actual] Original:', original, 'Transformado:', value);
        if (original === 'true') return true;
        if (original === 'false') return false;
        return value;
      })
      .required('Estado actual es obligatorio'),
    foto_path: yup.mixed().optional(),
    plan_desarrollo: yup.object().shape({
      titulo: yup.string().required('Título es obligatorio'),
      descripcion: yup.string().required('Descripción es obligatoria'),
      document_path: yup.mixed().optional(),
    }),
  });

  console.log('[useAlcaldeForm] Configurando formulario...');
  // Configuración del formulario - MEJORADO
  const { values, errors, meta, handleSubmit, resetForm, defineField, setFieldValue, setErrors } = useForm({
    validationSchema,
    initialValues: {
      ...initialData,
      plan_desarrollo: initialData.plan_desarrollo || {
        titulo: '',
        descripcion: '',
        document_path: ''
      }
    }
  });

  console.log('[useAlcaldeForm] Valores iniciales del formulario:', values);
  console.log('[useAlcaldeForm] Errores iniciales:', errors.value);

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

  // Query para cargar datos si estamos editando
  console.log('[useAlcaldeForm] Configurando query para datos de alcalde...');
  const alcaldeQuery = useQuery({
    queryKey: ['alcalde', initialData.id],
    queryFn: () => {
      console.log('[Query] Ejecutando getAlcaldeById para ID:', initialData.id);
      return getAlcaldeById(initialData.id!);
    },
    enabled: isEditing && !!initialData.id,
    staleTime: 30000,
  });

  console.log('[useAlcaldeForm] Estado inicial de la query:', {
    isLoading: alcaldeQuery.isLoading.value,
    isError: alcaldeQuery.isError.value,
    data: alcaldeQuery.data.value
  });

  // Observador para éxito en la carga - MEJORADO
  watch(() => alcaldeQuery.data.value, (data) => {
    console.log('[Watch] alcaldeQuery.data cambiado:', data);

    if (data) {
      console.log('[Carga de datos] Datos recibidos de la API:', data);

      const parsedData = {
        ...data,
        fecha_inicio: parseApiDate(data.fecha_inicio),
        fecha_fin: parseApiDate(data.fecha_fin),
        plan_desarrollo: {
          titulo: data.plan_desarrollo?.titulo ?? '',
          descripcion: data.plan_desarrollo?.descripcion ?? '',
          document_path: data.plan_desarrollo?.document_path ?? '',
        }
      };

      console.log('[Carga de datos] Datos parseados:', parsedData);

      resetForm({ values: parsedData });
      console.log('[Carga de datos] Formulario reseteado');

      // Actualizar campos específicos para asegurar reactividad
      console.log('[Carga de datos] Actualizando campos individualmente...');
      setFieldValue('nombre_completo', parsedData.nombre_completo);
      setFieldValue('presentacion', parsedData.presentacion);
      setFieldValue('fecha_inicio', parsedData.fecha_inicio);
      setFieldValue('fecha_fin', parsedData.fecha_fin);
      setFieldValue('sexo', parsedData.sexo);
      setFieldValue('actual', parsedData.actual);
      setFieldValue('plan_desarrollo.titulo', parsedData.plan_desarrollo.titulo);
      setFieldValue('plan_desarrollo.descripcion', parsedData.plan_desarrollo.descripcion);

      console.log('[Carga de datos] Campos actualizados. Valores actuales:', values);
    }
  });

  // Observador para errores en la carga
  watch(() => alcaldeQuery.isError.value, (isError) => {
    console.log('[Watch] alcaldeQuery.isError cambiado:', isError);

    if (isError) {
      const error = alcaldeQuery.error.value;
      console.error('[Carga de datos] Error cargando alcalde:', error);
      toast.error('Error cargando datos del alcalde');
      router.push('/admin/alcaldes');
    }
  });

  // Observador para valores del formulario
  watch(values, (newValues) => {
    console.log('[Watch] Valores del formulario cambiados:', newValues);
  }, { deep: true });

  // Observador para errores del formulario
  watch(errors, (newErrors) => {
    console.log('[Watch] Errores del formulario cambiados:', newErrors);
  }, { deep: true });

  // URLs para archivos
  const filePaths = computed(() => {
    const paths = {
      photo: tempPhotoUrl.value ||
             (values.foto_path ? `${API_BASE_URL}/storage/${values.foto_path}` : ''),
      document: values.plan_desarrollo?.document_path ?
                `${API_BASE_URL}/storage/${values.plan_desarrollo.document_path}` : ''
    };

    console.log('[Computed] filePaths:', paths);
    return paths;
  });

  // Manejadores de archivos
  const onImageSelected = (e: Event) => {
    console.log('[Evento] onImageSelected');
    const input = e.target as HTMLInputElement;

    if (input.files?.length) {
      newPhotoFile.value = input.files[0];
      console.log('[Archivo] Imagen seleccionada:', newPhotoFile.value.name);

      tempPhotoUrl.value = URL.createObjectURL(newPhotoFile.value);
      setFieldValue('foto_path', newPhotoFile.value.name);

      console.log('[Archivo] Valor de foto_path actualizado:', values.foto_path);
    }
  };

  const onPdfSelected = (e: Event) => {
    console.log('[Evento] onPdfSelected');
    const input = e.target as HTMLInputElement;

    if (input.files?.length) {
      newDocumentFile.value = input.files[0];
      selectedPdfName.value = input.files[0].name;
      console.log('[Archivo] PDF seleccionado:', selectedPdfName.value);

      setFieldValue('plan_desarrollo.document_path', newDocumentFile.value.name);
      console.log('[Archivo] Valor de document_path actualizado:', values.plan_desarrollo?.document_path);
    }
  };

  // Envío del formulario - MEJORADO
  const submitForm = handleSubmit(async (formValues) => {
    console.log('[Submit] Iniciando envío del formulario...');
    console.log('[Submit] Valores del formulario:', formValues);
    console.log('[Submit] Archivos seleccionados:', {
      photo: newPhotoFile.value?.name,
      document: newDocumentFile.value?.name
    });

    isPending.value = true;
    console.log('[Submit] Estado isPending: true');

    try {
      const formData = new FormData();
      console.log('[Submit] FormData creado');

      // Agregar campos básicos
      Object.entries(formValues).forEach(([key, value]) => {
        if (key === 'plan_desarrollo') return;

        // Manejo especial para fechas
        if (key === 'fecha_inicio' || key === 'fecha_fin') {
          const dateStr = formatDateForBackend(value as Date);
          console.log(`[Submit] Agregando fecha ${key}:`, dateStr);
          formData.append(key, dateStr);
        } else {
          console.log(`[Submit] Agregando campo ${key}:`, value);
          formData.append(key, String(value));
        }
      });

      // Agregar plan de desarrollo
      if (formValues.plan_desarrollo) {
        console.log('[Submit] Agregando plan_desarrollo:', formValues.plan_desarrollo);
        Object.entries(formValues.plan_desarrollo).forEach(([key, value]) => {
          formData.append(`plan_desarrollo[${key}]`, String(value));
        });
      }

      // Manejar archivos
      if (newPhotoFile.value) {
        console.log('[Submit] Agregando archivo de foto:', newPhotoFile.value.name);
        formData.append('foto_path', newPhotoFile.value);
      } else if (formValues.foto_path && !formValues.foto_path.startsWith('http')) {
        console.log('[Submit] Usando foto_path existente:', formValues.foto_path);
        formData.append('foto_path_existente', formValues.foto_path);
      }

      if (newDocumentFile.value) {
        console.log('[Submit] Agregando archivo de documento:', newDocumentFile.value.name);
        formData.append('document_path', newDocumentFile.value);
      } else if (
        formValues.plan_desarrollo?.document_path &&
        !formValues.plan_desarrollo.document_path.startsWith('http')
      ) {
        console.log('[Submit] Usando document_path existente:', formValues.plan_desarrollo.document_path);
        formData.append('document_path_existente', formValues.plan_desarrollo.document_path);
      }

      // ID para actualización
      if (isEditing && formValues.id) {
        console.log('[Submit] Agregando ID para actualización:', formValues.id);
        formData.append('id', formValues.id.toString());
      }

      // DEBUG: Mostrar contenido de FormData
      console.log('[Submit] Contenido de FormData:');
      for (const [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
      }

      // Enviar a API
      console.log('[Submit] Enviando datos a la API...');
      await createUpdateAlcalde(formData);
      console.log('[Submit] Datos enviados exitosamente');

      toast.success(isEditing ? 'Alcalde actualizado' : 'Alcalde creado');
      router.push('/admin/alcaldes');
    } catch (error: any) {
      console.error('[Submit] Error en el envío:', error);

      let errorMessage = 'Error al guardar';
      console.log('[Submit] Respuesta de error:', error.response);

      if (error.response?.data?.errors) {
        // Manejo de errores de validación del backend
        const validationErrors = Object.values(error.response.data.errors).flat();
        errorMessage = `Errores de validación:\n${validationErrors.join('\n')}`;

        // Actualizar errores en el formulario
        const formattedErrors = Object.entries(error.response.data.errors).reduce((acc, [key, messages]) => {
          acc[key] = (messages as string[]).join(', ');
          return acc;
        }, {} as Record<string, string>);

        console.log('[Submit] Actualizando errores del formulario:', formattedErrors);
        setErrors(formattedErrors);
      } else if (error.message) {
        if (error.message.includes('Error de validación')) {
          errorMessage = `Errores de validación:\n${error.message.split(': ')[1]}`;
        } else {
          errorMessage = error.message || errorMessage;
        }
      }

      toast.error(errorMessage);
    } finally {
      isPending.value = false;
      console.log('[Submit] Estado isPending: false');
    }
  });

  // Limpieza de recursos
  onUnmounted(() => {
    console.log('[Unmount] Limpiando recursos...');
    if (tempPhotoUrl.value) {
      URL.revokeObjectURL(tempPhotoUrl.value);
      console.log('[Unmount] URL de imagen temporal revocada');
    }
  });

  return {
    // Estado
    values,
    errors,
    meta,
    isPending,
    isLoading: computed(() => alcaldeQuery.isLoading.value),
    filePaths,
    selectedPdfName,

    // Campos y atributos
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

    // Métodos
    onImageSelected,
    onPdfSelected,
    submitForm,
    showDebug
  };
}
