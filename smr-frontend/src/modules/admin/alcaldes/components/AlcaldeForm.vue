<template>
  <div class="container my-4">
    <div class="card shadow-sm">
      <!-- Encabezado -->
      <div class="card-header bg-white border-start border-4 border-primary py-3">
        <div class="row align-items-center gx-3">
          <h3 class="col mb-0">{{ values.id ? 'Editar' : 'Crear' }} Alcalde</h3>
          <div v-if="filePaths.photo" class="col-auto text-center">
            <img
              :src="filePaths.photo"
              :alt="values.nombre_completo"
              class="img-thumbnail"
              style="max-height: 100px; object-fit: cover"
            />
          </div>
        </div>
      </div>

      <!-- Formulario -->
      <div class="card-body">
        <form @submit.prevent="onSubmit" class="row g-4">
          <!-- Columna Izquierda -->
          <div class="col-12 col-md-6">
            <CustomInput
              v-model="nombre_completo"
              v-bind="nombre_completoAttrs"
              label="Nombre completo"
              :error="errors.nombre_completo"
            />

            <CustomTextArea
              v-model="presentacion"
              v-bind="presentacionAttrs"
              label="Presentación"
              :error="errors.presentacion"
            />

            <div class="mb-3">
              <label class="form-label fw-semibold">Sexo</label>
              <select v-model="sexo" v-bind="sexoAttrs" class="form-select">
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
              </select>
              <span v-if="errors.sexo" class="text-danger small">{{ errors.sexo }}</span>
            </div>

            <div class="row gx-3">
              <div class="col">
                <CustomInputDate
                  v-model="fecha_inicio"
                  v-bind="fecha_inicioAttrs"
                  label="Fecha de inicio"
                  :error="errors.fecha_inicio"
                />
              </div>
              <div class="col">
                <CustomInputDate
                  v-model="fecha_fin"
                  v-bind="fecha_finAttrs"
                  label="Fecha de fin"
                  :error="errors.fecha_fin"
                />
              </div>
            </div>
          </div>

          <!-- Columna Derecha -->
          <div class="col-12 col-md-6">
            <CustomInput
              v-model="titulo"
              v-bind="tituloAttrs"
              label="Título del Plan"
              :error="errors['plan_desarrollo.titulo']"
            />

            <CustomTextArea
              v-model="descripcion"
              v-bind="descripcionAttrs"
              label="Descripción del Plan"
              :error="errors['plan_desarrollo.descripcion']"
            />

            <CustomDocument
              v-model="documentos"
              v-bind="documentPathAttrs"
              :existing-docs="existingDocuments"
              folder="planes/documentos"
              label="Documentos del Plan"
              :max-size="10"
              @update:modelValue="handleDocumentUpdate"
              @remove-existing-doc="removeExistingDocument"
            />
            <div v-if="errors['plan_desarrollo.documentos']" class="text-danger small mt-1">
              {{ errors['plan_desarrollo.documentos'] }}
            </div>

            <div class="form-check form-switch mb-3">
              <input
                v-model="actual"
                v-bind="actualAttrs"
                class="form-check-input"
                type="checkbox"
                id="actualCheck"
              />
              <label class="form-check-label fw-semibold" for="actualCheck">Alcalde Actual</label>
            </div>

            <CustomImagen
              v-model="fotoPath"
              folder="alcaldes/fotos"
              label="Foto de perfil"
              :max-size="5"
              :error="errors.foto_path"
            />
          </div>

          <!-- Botón de envío -->
          <div class="col-12 text-end">
            <button type="submit" :disabled="isPending" class="btn btn-primary">
              <span v-if="isPending" class="spinner-border spinner-border-sm me-2"></span>
              {{ values.id ? 'Actualizar' : 'Guardar' }} Alcalde
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script src="../views/alcaldeView.ts" lang="ts"></script>
