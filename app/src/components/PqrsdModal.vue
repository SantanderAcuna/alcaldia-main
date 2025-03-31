<template>
    <div class="modal-overlay" v-if="isOpen">
        <div class="modal">
            <h2>{{ editMode ? 'Editar PQRSD' : 'Crear PQRSD' }}</h2>
            <form @submit.prevent="submitForm">
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <select v-model="pqrsd.tipo" required>
                        <option value="Reclamo">Reclamo</option>
                        <option value="Denuncia">Denuncia</option>
                        <option value="Queja">Queja</option>
                        <option value="Sugerencia">Sugerencia</option>
                    </select>
                    <span v-if="v$.tipo.$error" class="error-msg">Tipo es obligatorio.</span>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea v-model="pqrsd.descripcion"></textarea>
                    <span v-if="v$.descripcion.$error" class="error-msg">Mínimo 10 caracteres.</span>
                </div>

                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select v-model="pqrsd.estado" required>
                        <option value="Abierto">Abierto</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Cerrado">Cerrado</option>
                    </select>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">{{ editMode ? 'Actualizar' : 'Guardar' }}</button>
                    <button type="button" class="btn-cancel" @click="closeModal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';
import { useVuelidate } from '@vuelidate/core';
import { required, minLength } from '@vuelidate/validators';
import { createPqrsd, updatePqrsd } from '../services/apiService.js';


const props = defineProps(['isOpen', 'pqrsdData', 'editMode']);
const emit = defineEmits(['close', 'refreshData']);

const pqrsd = ref({ tipo: '', descripcion: '', estado: 'Abierto' });

watch(
    () => props.pqrsdData,
    (newValue) => {
        pqrsd.value = { ...newValue };
    },
    { deep: true, immediate: true }
);

const rules = {
    tipo: { required },
    descripcion: { required, minLength: minLength(10) },
};

const v$ = useVuelidate(rules, pqrsd);

const submitForm = async () => {
    v$.value.$validate();
    if (v$.value.$invalid) return;

    try {
        if (props.editMode) {
            await updatePqrsd(pqrsd.value.id, pqrsd.value);
        } else {
            const response = await createPqrsd(pqrsd.value);
            pqrsd.value.id = response.data.id; // Asegurar que el ID se actualiza
        }

        alert(`PQRSD ${props.editMode ? 'actualizado' : 'creado'} correctamente`);
        emit('refreshData'); // Refrescar la tabla de PQRSD
        closeModal();
    } catch (error) {
        console.error(`Error ${props.editMode ? 'actualizando' : 'creando'} PQRSD:`, error);
    }
};

const closeModal = () => {
    emit('close');
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
}

.form-group {
    margin-bottom: 10px;
}

label {
    font-weight: bold;
}

textarea,
select {
    width: 100%;
    padding: 5px;
    margin-top: 5px;
}

.error-msg {
    color: red;
    font-size: 12px;
}

.form-buttons {
    display: flex;
    justify-content: space-between;
}

.btn-save {
   
    color: white;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
}

.btn-cancel {
   
    color: white;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
}
</style>