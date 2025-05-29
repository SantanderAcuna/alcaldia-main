<template>
  <div class="container">
    <h1>Gabinete</h1>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
      <div class="col" v-for="(miembro, index) in miembros" :key="index">
        <div class="card h-100 card-custom shadow-sm">
          <img 
            :src="`logo500text=${getIniciales(miembro.nombre)}`" 
            class="card-img-top profile-img" 
            :alt="miembro.nombre"
          >
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ miembro.nombre }}</h5>
            <p class="card-text text-muted">{{ miembro.cargo }}</p>
            <div class="mt-auto">
              <button class="btn btn-custom">Ver Perfil</button>
              <button class="btn btn-custom">Ver Dependencia</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import logo500 from '@/assets/logo50.png';

const miembros = reactive([
  {nombre: "Camillo George Díaz", cargo: "Secretario de Gobierno"},
  {nombre: "Safuat Atunes Celedón", cargo: "Jefe Oficina Despacho"},
  {nombre: "Gustavo Berdugo Garquito", cargo: "Secretario de Seguridad y Convivencia"},
  {nombre: "Dario José Linero Mejía", cargo: "Secretario de Cultura"},
  {nombre: "Fidel Castro Tapia", cargo: "Secretario de Movilidad Multimodal y Sostenible"},
  {nombre: "Cecilia Restrepo", cargo: "Gerente de Desarrollo Urbano de Santa"},
  {nombre: "Sandra Patricia Muñoz", cargo: "Secretario de Educación"},
  {nombre: "Patricia Lucia Calcedo Lafaurie", cargo: "Secretaria de Planeación"},
  {nombre: "Jorge Lastra Cantillo", cargo: "Secretario de Salud del Distrito"},
  {nombre: "Claudia Marcela Cuello Dara", cargo: "Secretario General"},
  {nombre: "Carlos José Jaramillo Río", cargo: "Secretario de Desarrollo Económico y Competitividad"},
  {nombre: "Rigoberto García Quiller", cargo: "Director de las Tecnologías de la Información y Comunicaciones (TIC)"},
  {nombre: "Hidéraldo Espinosa Vitoria", cargo: "Director del Instituto Distrital Para la Recreación y el Deporte (Inred)"},
  {nombre: "José Domingo Dóvila", cargo: "Director del Instituto Distrital de turismo (indetur)"},
  {nombre: "Hirán David Ramírez", cargo: "Henroy Director de Contratación"},
  {nombre: "Pedía Gómez", cargo: "Directora del Dpto Administrativo Distrital Para la Sostenibilidad Ambiental (Dadas)"},
  {nombre: "Sarita Vives Gutiérrez", cargo: "Alta Consejería para la sierra novada y zona rural"},
  {nombre: "Karel Paola Dau", cargo: "Crespo Jefe de Oficina Asesora de Comunicaciones Estratégicas"},
  {nombre: "Ingrid Gómez Caballos", cargo: "Secretaria de la Mujer y Equidad de Género"},
  {nombre: "Rafael Rojas Matos", cargo: "Director Jurídica Distrital de Santa Marta"}
]);

const getIniciales = (nombre) => {
  const partes = nombre.split(' ');
  return partes[0][0] + (partes[1]?.[0] || '');
};
</script>

<style scoped>
.card-custom {
  transition: transform 0.3s;
  min-height: 420px;
}

.card-custom:hover {
  transform: translateY(-10px);
}

.profile-img {
  height: 200px;
  object-fit: cover;
  border-bottom: 3px solid #007bff;
}

.btn-custom {
  background-color: #007bff;
  color: white;
  width: 100%;
  margin: 5px 0;
}

.btn-custom:hover {
  background-color: #0056b3;
}

h1 {
  color: #2c3e50;
  margin: 30px 0;
  text-align: center;
  font-weight: bold;
}
</style>