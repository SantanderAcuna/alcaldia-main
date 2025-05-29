<template>
  <div class="macro-container">
    <h1 class="macro-title">Noticias de Santa Marta</h1>

    <div class="row news-grid">
      <div
        v-for="(news, index) in limitedNews"
        :key="index"
        class="col-lg-4 col-md-6 col-12 mb-4 d-flex"
      >
        <div
          class="card w-100 shadow-sm border-0 rounded-4 d-flex flex-column news-fixed-height"
        >
          <img
            :src="news.image"
            :alt="'Noticia ' + (index + 1)"
            class="card-img-top rounded-top-4"
            style="object-fit: cover; height: 180px"
          />
          <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-2 gap-2">
              <h6 class="text-muted small mb-0">MARZO 2020</h6>
              <span
                v-if="news.tag"
                class="badge bg-primary text-uppercase small"
              >
                Liderazgo
              </span>
            </div>

            <p class="card-text flex-grow-1 text-truncate-multiline">
              {{ news.text }}
            </p>

            <a href="" class="btn btn-outline-primary mt-2 align-self-start">
              Leer más
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";

// Usando imágenes públicas (asegúrate de tener estas imágenes en tu carpeta public/img)
const newsItems = [
  {
    tag: "TRANSIENTO Y SEGURIDAD (SALVA)",
    text: "Por jornada de impulsar clares sobre el evento, no carece calles 70 y 72 clare abaixo 10 dh...",
    image: "1.png",
  },
  {
    text: "La coche legal a la encuentra, conexa el ABC de este evento global establecido (SALVA)",
    image: "1.png",
  },
  {
    text: "\"Nay pronto tendremos a 'Bé' brevedores de los Corros presionados en tercera digna en la Braga...\"",
    image: "1.png",
  },
  {
    tag: "GRASA PELECIÓN",
    text: "\"Nay pronto tendremos a 'Bé' brevedores de los Corros presionados en tercera digna en la Braga...\"",
    image: "1.png",
  },
  {
    text: "Contenido de la quinta noticia de ejemplo para completar el grid",
    image: "1.png",
  },
  {
    text: "Contenido de la sexta noticia de ejemplo para completar el grid",
    image: "1.png",
  },
];

// Limitar a 6 noticias como solicitado
const limitedNews = computed(() => newsItems.slice(0, 6));
</script>

<style scoped>
.macro-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: "Arial", sans-serif;
}

.macro-title {
  font-size: 2rem;
  text-align: center;
  margin-bottom: 30px;
  color: #333;
  border-bottom: 2px solid #eee;
  padding-bottom: 15px;
}

.news-grid {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -15px;
}

.news-item {
  padding: 0 15px;
  margin-bottom: 30px;
  box-sizing: border-box;
}

.news-card {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  height: 100%;
  display: flex;
  flex-direction: column;
}

.news-header {
  background-color: #f8f9fa;
  padding: 12px 15px;
  border-bottom: 1px solid #eaeaea;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}

.news-date {
  font-size: 1.1rem;
  color: #444;
  margin: 0;
  margin-right: 10px;
}

.news-tag {
  background-color: #2c7be5;
  color: white;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 0.75rem;
}

.news-content {
  padding: 15px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.news-image {
  width: 100%;
  height: 180px;
  border-radius: 4px;
  margin-bottom: 15px;
  object-fit: cover;
  background-color: #f0f0f0; /* Color de fondo mientras carga */
}

.news-text {
  font-size: 0.9rem;
  line-height: 1.5;
  color: #555;
  margin: 0;
  flex-grow: 1;
}

/* Responsive columns */
@media (min-width: 992px) {
  .col-lg-4 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
  }
}

@media (min-width: 768px) and (max-width: 991.98px) {
  .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
  }
}

@media (max-width: 767.98px) {
  .col-12 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .macro-title {
    font-size: 1.8rem;
  }

  .news-date {
    font-size: 1rem;
  }

  .news-tag {
    font-size: 0.7rem;
  }

  .news-image {
    height: 150px;
  }
}
</style>
