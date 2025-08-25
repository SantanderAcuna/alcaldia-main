import { defineComponent, watch, computed, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query';
import { useForm, useFieldArray } from 'vee-validate';
import * as yup from 'yup';
import { createUpdateSecretaria, deleteSecretaria, getSecretariaById } from '../actions';
import CustomInput from '@/modules/admin/components/CustomInput.vue';
import CustomTextArea from '@/modules/admin/components/CustomTextArea.vue';
import CustomInputDate from '@/modules/admin/components/CustomInputDate.vue';
import CustomDocument from '@/modules/admin/components/CustomDocument.vue';
import CustomImagen from '@/modules/admin/components/CustomImagen.vue';

import { useToast } from 'vue-toast-notification';
import type { Dependencia, Funcionario, Funciones, Tramite } from '@/modules/interfaces';
import type { ApiError } from '@/modules/interfaces/response';

interface FormValues {
  id?: number | null;
  nombre?: string;
  mision?: string;
  vision?: string;
  organigrama?: File | string | null;
  created_at?: string;
  updated_at?: string;
  funciones?: Funciones[];
  dependencias?: Dependencia[];
  tramites?: Tramite[];
  funcionarios?: Funcionario[];
}

const $toast = useToast();
// const toSafeDate = (value: unknown): Date | null => {
//   if (value instanceof Date) return isNaN(value.getTime()) ? null : value;
//   if (typeof value === 'string' || typeof value === 'number') {
//     const date = new Date(value);
//     return isNaN(date.getTime()) ? null : date;
//   }
//   return null;
// };

// Schema de validación corregido
const validationSchema = yup.object({
  nombre: yup.string().required('Nombre es obligatorio'),
  mision: yup.string().required('Misión es obligatoria'),
  vision: yup.string().required('Visión es obligatoria'),
  organigrama: yup
    .mixed()
    .required('Organigrama es obligatorio')
    .test('is-file-or-string', 'Debe ser un archivo o URL válida', (value) => {
      return value instanceof File || typeof value === 'string';
    }),
  funciones: yup.array().of(
    yup.object({
      nombre: yup.string().required('Nombre de función es obligatorio'),
      orden: yup.number().required('Orden es obligatorio').positive().integer(),
    }),
  ),
  dependencias: yup.array().of(
    yup.object({
      nombre: yup.string().required('Nombre de dependencia es obligatorio'),
      descripcion: yup.string().required('Descripción es obligatoria'),
    }),
  ),
  tramites: yup.array().of(
    yup.object({
      nombre: yup.string().required('Nombre de trámite es obligatorio'),
      descripcion: yup.string().required('Descripción es obligatoria'),
    }),
  ),
  funcionarios: yup.array().of(
    yup.object({
      nombres: yup.string().required('Nombres son obligatorios'),
      apellidos: yup.string().required('Apellidos son obligatorios'),
      cargo: yup.string().required('Cargo es obligatorio'),
      genero: yup.string().required('Género es obligatorio').oneOf(['M', 'F']),
      correo: yup.string().email('Correo inválido').required('Correo es obligatorio'),
      linkendin: yup.string().required('LinkedIn es obligatorio'),
      fecha_ingreso: yup
        .date()
        .required('Fecha de ingreso es obligatoria')
        .typeError('Fecha inválida'),
      estado: yup.string().required('Estado es obligatorio'),
      foto: yup
        .mixed()
        .required('Foto es obligatoria')
        .test('is-file-or-string', 'Debe ser un archivo o URL válida', (value) => {
          return value instanceof File || typeof value === 'string';
        }),
    }),
  ),
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
    const queryClient = useQueryClient();

    const secretariaId = computed(() => {
      const id = Number(route.params.id);
      return isNaN(id) ? null : id;
    });

    const API_STORAGE_URL = `${import.meta.env.VITE_API_BASE_URL}/storage`;
    const resetKey = ref(0);

    // Configuración del formulario con campos de arreglo
    const { values, errors, handleSubmit, resetForm, defineField } = useForm<FormValues>({
      validationSchema,
      initialValues: {
        id: null,
        nombre: '',
        mision: '',
        vision: '',
        organigrama: null,
        funciones: [],
        dependencias: [],
        tramites: [],
        funcionarios: [],
      },
    });

    // Campos de arreglo

    const {
      fields: funcionesFields,
      remove: removeFuncion,
      push: pushFuncion,
    } = useFieldArray<Funciones>('funciones');

    const {
      fields: dependenciasFields,
      remove: removeDependencia,
      push: pushDependencia,
    } = useFieldArray<Dependencia>('dependencias');

    const {
      fields: tramitesFields,
      remove: removeTramite,
      push: pushTramite,
    } = useFieldArray<Tramite>('tramites');

    const {
      fields: funcionariosFields,
      remove: removeFuncionario,
      push: pushFuncionario,
    } = useFieldArray<Funcionario>('funcionarios');

    // Definición de campos individuales (SECRETARÍA)
    const [nombre, nombreAttrs] = defineField('nombre');
    const [mision, misionAttrs] = defineField('mision');
    const [vision, visionAttrs] = defineField('vision');
    const [organigrama, organigramaAttrs] = defineField('organigrama');

    // Definición de campos para ARRAYS (primer elemento)
    const [nombreFunciones, nombreFuncionesAttrs] = defineField('funciones[0].nombre');
    const [ordenFunciones, ordenFuncionesAttrs] = defineField('funciones[0].orden');
    const [nombreDependencia, nombreDependenciaAttrs] = defineField('dependencias[0].nombre');
    const [descripcionDependencia, descripcionDependenciaAttrs] = defineField(
      'dependencias[0].descripcion',
    );
    const [nombreTramites, nombreTramitesAttrs] = defineField('tramites[0].nombre');
    const [descripcionTramites, descripcionTramitesAttrs] = defineField('tramites[0].descripcion');
    const [nombres, nombresAttrs] = defineField('funcionarios[0].nombres');
    const [apellidos, apellidosAttrs] = defineField('funcionarios[0].apellidos');
    const [cargo, cargoAttrs] = defineField('funcionarios[0].cargo');
    const [genero, generoAttrs] = defineField('funcionarios[0].genero');
    const [correo, correoAttrs] = defineField('funcionarios[0].correo');
    const [linkendin, linkendinAttrs] = defineField('funcionarios[0].linkendin');
    const [fecha_ingreso, fecha_ingresoAttrs] = defineField('funcionarios[0].fecha_ingreso');
    const [estado, estadoAttrs] = defineField('funcionarios[0].estado');

    // Query para obtener datos de la secretaria
    const { data: secretariaData, error: queryError } = useQuery({
      queryKey: ['secretaria', secretariaId.value],
      queryFn: () => {
        if (!secretariaId.value) throw new Error('ID inválido');
        return getSecretariaById(secretariaId.value);
      },
      enabled: !!secretariaId.value,
      staleTime: 30000,
    });

    watch(queryError, (error) => {
      if (error) {
        $toast.error(error.message || 'Error al cargar los datos');
        console.error('Error loading secretaria:', error);
      }
    });

    // Cargar datos en el formulario
    watch(
      () => secretariaData.value,
      (response) => {
        const secretaria = response?.data;
        if (!secretaria) {
          $toast.info('Cargando información...');
          return;
        }

        try {
          // Manejo correcto de arrays
          const initialValues: FormValues = {
            id: secretaria.id,
            nombre: secretaria.nombre || '',
            mision: secretaria.mision || '',
            vision: secretaria.vision || '',
            organigrama: secretaria.organigrama || null,
            funciones: secretaria.funciones || [],
            dependencias: secretaria.dependencias || [],
            tramites: secretaria.tramites || [],
            funcionarios: secretaria.funcionarios || [],
          };

          resetForm({ values: initialValues });
          resetKey.value++;
        } catch (error) {
          console.error('Error al procesar datos:', error);
          $toast.error('Error al cargar los datos de la secretaría');
        }
      },
      { immediate: true, deep: true },
    );

    // Mutation para crear/actualizar
    const { mutate, isPending } = useMutation({
      mutationFn: createUpdateSecretaria,
      onSuccess: () => {
        queryClient.invalidateQueries({ queryKey: ['secretaria', secretariaId.value] });
        queryClient.invalidateQueries({ queryKey: ['secretarias'] });
        router.push('/admin/secretarias-admin');
        $toast.success('Secretaría guardada exitosamente');
      },
      onError: (error: ApiError) => {
        $toast.error(error.message || 'Error al guardar la secretaría');
        console.error('Mutation error:', error);
      },
    });

    // Mutation para eliminar secretaria
    const { mutate: deleteMutation } = useMutation({
      mutationFn: (id: number) => deleteSecretaria(id),
      onSuccess: () => {
        queryClient.invalidateQueries({ queryKey: ['secretarias'] });
        $toast.success('Secretaría eliminada exitosamente');
        router.push('/admin/secretarias-admin');
      },
      onError: (error: ApiError) => {
        $toast.error(error.message || 'Error al eliminar la secretaría');
      },
    });

    const eliminarSecretaria = () => {
      if (!values.id) return;
      if (confirm('¿Estás seguro de eliminar esta secretaría?')) {
        deleteMutation(values.id);
      }
    };

    // Manejo de fechas
    const formatDateForSubmit = (date: Date | string | null | undefined): string => {
      if (!date) return '';
      try {
        const parsedDate = date instanceof Date ? date : new Date(date);
        return isNaN(parsedDate.getTime()) ? '' : parsedDate.toISOString().split('T')[0];
      } catch {
        return '';
      }
    };

    // Envío del formulario
    const onSubmit = handleSubmit(async (formValues) => {
      const formData = new FormData();

      // Campos básicos
      formData.append('nombre', formValues.nombre || '');
      formData.append('mision', formValues.mision || '');
      formData.append('vision', formValues.vision || '');

      // Manejo de archivos
      if (formValues.organigrama instanceof File) {
        formData.append('organigrama', formValues.organigrama);
      } else if (typeof formValues.organigrama === 'string') {
        formData.append('organigrama', formValues.organigrama);
      }

      // Funciones
      formValues.funciones?.forEach((funcion, index) => {
        formData.append(`funciones[${index}][nombre]`, funcion.nombre || '');
        formData.append(`funciones[${index}][orden]`, String(funcion.orden || ''));
      });

      // Dependencias
      formValues.dependencias?.forEach((dependencia, index) => {
        formData.append(`dependencias[${index}][nombre]`, dependencia.nombre || '');
        formData.append(`dependencias[${index}][descripcion]`, dependencia.descripcion || '');
      });

      // Trámites
      formValues.tramites?.forEach((tramite, index) => {
        formData.append(`tramites[${index}][nombre]`, tramite.nombre || '');
        formData.append(`tramites[${index}][descripcion]`, tramite.descripcion || '');
      });

      // Funcionarios
      formValues.funcionarios?.forEach((funcionario, index) => {
        formData.append(`funcionarios[${index}][nombres]`, funcionario.nombres || '');
        formData.append(`funcionarios[${index}][apellidos]`, funcionario.apellidos || '');
        formData.append(`funcionarios[${index}][cargo]`, funcionario.cargo || '');
        formData.append(`funcionarios[${index}][genero]`, funcionario.genero || '');
        formData.append(`funcionarios[${index}][correo]`, funcionario.correo || '');
        formData.append(`funcionarios[${index}][linkendin]`, funcionario.linkendin || '');
        formData.append(
          `funcionarios[${index}][fecha_ingreso]`,
          formatDateForSubmit(funcionario.fecha_ingreso),
        );
        formData.append(`funcionarios[${index}][estado]`, funcionario.estado || '');

        if (funcionario.foto instanceof File) {
          formData.append(`funcionarios[${index}][foto]`, funcionario.foto);
        } else if (typeof funcionario.foto === 'string') {
          formData.append(`funcionarios[${index}][foto]`, funcionario.foto);
        }
      });

      // ID para actualización
      if (formValues.id) {
        formData.append('id', formValues.id.toString());
        formData.append('_method', 'PATCH');
      }

      mutate(formData);
    });

    // URLs para visualización
    const fileOrganigrama = computed(() => {
      if (!values.organigrama) return null;
      if (values.organigrama instanceof File) {
        return URL.createObjectURL(values.organigrama);
      }
      return `${API_STORAGE_URL}/${values.organigrama}`;
    });

    // URLs para fotos de funcionarios
    const funcionarioFotos = computed(() => {
      return (
        values.funcionarios?.map((func) => {
          if (!func.foto) return null;
          if (func.foto instanceof File) {
            return URL.createObjectURL(func.foto);
          }
          return `${API_STORAGE_URL}/${func.foto}`;
        }) || []
      );
    });

    return {
      values,
      errors,
      isPending,
      fileOrganigrama,
      funcionarioFotos,
      resetKey,
      funcionesFields,
      dependenciasFields,
      tramitesFields,
      funcionariosFields,
      //campos form
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

      onSubmit,
      eliminarSecretaria,
    };
  },
});
