<template>
  <div class="container my-4">
    <div class="card shadow-sm">
      <div class="card-header bg-white border-start border-4 border-primary py-3">
        <div class="row align-items-center gx-3">
          <h3 class="col mb-0">{{ values.id ? 'Editar' : 'Crear' }} Secretaría</h3>
          <div v-if="fileOrganigrama" class="col-auto text-center">
            <img
              :src="fileOrganigrama"
              :alt="values.nombre"
              class="img-thumbnail"
              style="max-height: 100px; object-fit: cover"
            />
          </div>
        </div>
      </div>

      <div class="card-body">
        <form @submit.prevent="onSubmit" class="row g-4">
          <!-- Campos principales -->
          <div class="col-12 col-md-6">
            <CustomInput
              v-model="nombre"
              v-bind="nombreAttrs"
              label="Nombre de la secretaría"
              :error="errors.nombre"
              required
            />

            <CustomTextArea
              v-model="mision"
              v-bind="misionAttrs"
              label="Misión"
              :error="errors.mision"
              required
              rows="3"
            />

            <CustomTextArea
              v-model="vision"
              v-bind="visionAttrs"
              label="Visión"
              :error="errors.vision"
              required
              rows="3"
            />

            <CustomImagen
              v-model="organigrama"
              v-bind="organigramaAttrs"
              label="Organigrama"
              :error="errors.organigrama"
              required
              accept="image/*"
            />
          </div>

          <!-- Columna derecha -->
          <div class="col-12 col-md-6">
            <!-- Funciones -->
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h5 class="mb-0">Funciones</h5>
              </div>
              <div class="card-body">
                <div v-for="(field, idx) in funcionesFields" :key="field.key" class="mb-3">
                  <div class="row g-2">
                    <div class="col-8">
                      <CustomInput
                        v-model="nombreFunciones"
                        v-bind="nombreFuncionesAttrs"
                        :label="`Función ${idx + 1}`"
                        :error="errors[`funciones[${idx}].nombre`]"
                        required
                      />
                    </div>
                    <div class="col-3">
                      <CustomInput
                        v-model="ordenFunciones"
                        v-bind="ordenFuncionesAttrs"
                        label="Orden"
                        type="number"
                        :error="errors[`funciones[${idx}].orden`]"
                        required
                      />
                    </div>
                    <div class="col-1 d-flex align-items-end">
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="funcionesFields.remove(idx)"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <button
                  type="button"
                  class="btn btn-outline-primary btn-sm"
                  @click="funcionesFields.push({ nombre: '', orden: 0 })"
                >
                  <i class="bi bi-plus"></i> Añadir Función
                </button>
              </div>
            </div>

            <!-- Dependencias -->
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h5 class="mb-0">Dependencias</h5>
              </div>
              <div class="card-body">
                <div v-for="(field, idx) in dependenciasFields" :key="field.key" class="mb-3">
                  <div class="row g-2">
                    <div class="col-9">
                      <CustomInput
                        v-model="nombreDependencia"
                        v-bind="nombreDependenciaAttrs"
                        :label="`Dependencia ${idx + 1}`"
                        :error="errors[`dependencias[${idx}].nombre`]"
                        required
                      />
                    </div>
                    <div class="col-3">
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="dependenciasFields.remove(idx)"
                      >
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                    <div class="col-12">
                      <CustomTextArea
                        v-model="descripcionDependencia"
                        v-bind="descripcionDependenciaAttrs"
                        label="Descripción"
                        :error="errors[`dependencias[${idx}].descripcion`]"
                        required
                      />
                    </div>
                  </div>
                </div>
                <button
                  type="button"
                  class="btn btn-outline-primary btn-sm"
                  @click="dependenciasFields.push({ nombre: '', descripcion: '' })"
                >
                  <i class="bi bi-plus"></i> Añadir Dependencia
                </button>
              </div>
            </div>

            <!-- Trámites -->
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h5 class="mb-0">Trámites</h5>
              </div>
              <div class="card-body">
                <div v-for="(field, idx) in tramitesFields" :key="field.key" class="mb-3">
                  <div class="row g-2">
                    <div class="col-9">
                      <CustomInput
                        v-model="nombreTramites"
                        v-bind="nombreTramitesAttrs"
                        :label="`Trámite ${idx + 1}`"
                        :error="errors[`tramites[${idx}].nombre`]"
                        required
                      />
                    </div>
                    <div class="col-3">
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="tramitesFields.remove(idx)"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                    <div class="col-12">
                      <CustomTextArea
                        v-model="descripcionDependencia"
                        v-bind="descripcionTramitesAttrs"
                        label="Descripción"
                        :error="errors[`tramites[${idx}].descripcion`]"
                        required
                      />
                    </div>
                  </div>
                </div>
                <button
                  type="button"
                  class="btn btn-outline-primary btn-sm"
                  @click="tramitesFields.push({ nombre: '', descripcion: '' })"
                >
                  <i class="bi bi-plus"></i> Añadir Trámite
                </button>
              </div>
            </div>

            <!-- Funcionarios -->
            <div class="card">
              <div class="card-header bg-light">
                <h5 class="mb-0">Funcionarios</h5>
              </div>
              <div class="card-body">
                <div v-for="(field, idx) in funcionariosFields" :key="field.key" class="mb-3">
                  <div class="row g-2">
                    <div class="col-md-6">
                      <CustomInput
                        v-model="nombres"
                        v-bind="nombresAttrs"
                        label="Nombres"
                        :error="errors[`funcionarios[${idx}].nombres`]"
                        required
                      />
                    </div>
                    <div class="col-md-6">
                      <CustomInput
                        v-model="apellidos"
                        v-bind="apellidosAttrs"
                        label="Apellidos"
                        :error="errors[`funcionarios[${idx}].apellidos`]"
                        required
                      />
                    </div>
                    <div class="col-12">
                      <CustomInput
                        v-model="cargo"
                        v-bind="cargoAttrs"
                        label="Cargo"
                        :error="errors[`funcionarios[${idx}].cargo`]"
                        required
                      />
                    </div>
                    <div class="col-md-6">
                      <CustomInput
                        v-model="genero"
                        v-bind="generoAttrs"
                        label="Género"
                        :error="errors[`funcionarios[${idx}].genero`]"
                        required
                      />
                    </div>
                    <div class="col-md-6">
                      <CustomInput
                        v-model="correo"
                        v-bind="correoAttrs"
                        label="Correo"
                        :error="errors[`funcionarios[${idx}].correo`]"
                        required
                      />
                    </div>
                    <div class="col-12">
                      <CustomInput
                        v-model="linkendin"
                        v-bind="linkendinAttrs"
                        label="LinkedIn"
                        :error="errors[`funcionarios[${idx}].linkendin`]"
                        required
                      />
                    </div>
                    <div class="col-md-6">
                      <CustomInputDate
                        v-model="fecha_ingreso"
                        v-bind="fecha_ingresoAttrs"
                        label="Fecha de ingreso"
                        :error="errors[`funcionarios[${idx}].fecha_ingreso`]"
                        required
                      />
                    </div>
                    <div class="col-md-6">
                      <CustomInput
                        v-model="estado"
                        v-bind="estadoAttrs"
                        label="Estado"
                        :error="errors[`funcionarios[${idx}].estado`]"
                        required
                      />
                    </div>
                    <div class="col-12">
                      <CustomImagen
                        v-model="foto"
                        label="Foto"
                        :error="errors[`funcionarios[${idx}].foto`]"
                        required
                      />
                    </div>
                    <div class="col-12 text-end">
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="funcionariosFields.remove(idx)"
                      >
                        <i class="bi bi-trash"></i> Eliminar
                      </button>
                    </div>
                  </div>
                </div>
                <button
                  type="button"
                  class="btn btn-outline-primary btn-sm"
                  @click="
                    funcionariosFields.push({
                      nombres: '',
                      apellidos: '',
                      cargo: '',
                      genero: 'M',
                      foto: null,
                      correo: '',
                      linkendin: '',
                      fecha_ingreso: '',
                      estado: 'Activo',
                    })
                  "
                >
                  <i class="bi bi-plus"></i> Añadir Funcionario
                </button>
              </div>
            </div>
          </div>

          <!-- Botones de acción -->
          <div class="col-12">
            <div class="d-flex justify-content-between">
              <button
                v-if="values.id"
                type="button"
                class="btn btn-danger"
                @click="eliminarSecretaria"
                :disabled="isPending"
              >
                Eliminar
              </button>
              <button type="submit" :disabled="isPending" class="btn btn-primary ms-auto">
                <span v-if="isPending" class="spinner-border spinner-border-sm me-2"></span>
                {{ values.id ? 'Actualizar' : 'Guardar' }} Secretaría
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script src="../views/secretariaView.ts" lang="ts"></script>
