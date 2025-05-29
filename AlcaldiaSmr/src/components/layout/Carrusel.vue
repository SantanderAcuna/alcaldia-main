<template>
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" ref="carouselElement">
      <div class="carousel-indicators">
        <button 
          v-for="(_, index) in 10" 
          :key="index"
          type="button" 
          data-bs-target="#carouselExampleAutoplaying"
          :data-bs-slide-to="index"
          :class="{ 'active': index === 0 }"
          :aria-label="'Slide ' + (index + 1)"
        ></button>
      </div>
  
      <div class="carousel-inner">
        <div 
          v-for="(item, index) in slides" 
          :key="index"
          class="carousel-item"
          :class="{ 'active': index === 0 }"
        >
          <img 
            :src="item" 
            class="d-block w-100" 
            :alt="'Slide ' + (index + 1)"
          >
        </div>
      </div>
  
      <button 
        class="carousel-control-prev" 
        type="button" 
        data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button 
        class="carousel-control-next" 
        type="button" 
        data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </template>
  
  <script>
  import { defineComponent, ref, onMounted } from 'vue';
  import { Carousel } from 'bootstrap';
  
  // Importa las imágenes
  import img1 from '@/assets/img/banner/Atencion al ciudadano-05.jpg';
  import img2 from '@/assets/img/banner/BANNER WEB ALCALDIA_3.jpg';
  import img3 from '@/assets/img/banner/BANNER WEB ALCALDIA_5l.jpg';
  import img4 from '@/assets/img/banner/BANNER WEB ALCALDIA_12.jpg';
  import img5 from '@/assets/img/banner/BANNER WEB ALCALDIA_15.jpg';
  import img6 from '@/assets/img/banner/BANNER WEB ALCALDIA_17.jpg';
  import img7 from '@/assets/img/banner/BANNER WEB ALCALDIA_18.jpg';
  import img8 from '@/assets/img/banner/BannerWebSantaMarta.jpg';
  import img9 from '@/assets/img/banner/Decreto-889-de-diciembre-30-2024-copia.png';

  
  export default defineComponent({
    name: 'BannerCarousel',
    setup() {
      const carouselElement = ref(null);
      const slides = [img1, img2, img3,img4];
      let carouselInstance = null;
  
      onMounted(() => {
        if (carouselElement.value) {
          carouselInstance = new Carousel(carouselElement.value, {
            interval: 5000,
            ride: 'carousel'
          });
        }
      });
  
      return {
        carouselElement,
        slides
      };
    }
  });
  </script>