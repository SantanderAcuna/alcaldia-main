<template>
  <div class="documents-container">
    <h1 class="section-title">Últimos Documentos</h1>
    
    <div class="row documents-grid">
      <div 
        v-for="(doc, index) in limitedDocuments" 
        :key="index" 
        class="document-item col-lg-4 col-md-6 col-12"
      >
        <div class="document-card">
          <div class="document-info">
            <span class="document-date">{{ doc.date }}</span>
            <span class="document-type">{{ doc.type }}</span>
            <span class="document-number">{{ doc.number }}</span>
          </div>
          <button class="download-btn">DESCARGAR</button>
        </div>
      </div>
    </div>
    
    <button class="more-documents-btn">+ Documentos</button>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const documents = [
  { date: "30, ABR 2025", type: "NORMATIVIDAD", number: "Gaceta No. 1172" },
  { date: "29, ABR 2025", type: "NORMATIVIDAD", number: "Gaceta No. 1171" },
  { date: "28, ABR 2025", type: "NORMATIVIDAD", number: "Gaceta No. 1170" },
  { date: "25, ABR 2025", type: "NORMATIVIDAD", number: "Gaceta No. 1169-2" },
  { date: "24, ABR 2025", type: "NORMATIVIDAD", number: "Gaceta No. 1169-1" },
  { date: "23, ABR 2025", type: "NORMATIVIDAD", number: "Gaceta No. 1168" }
];

// Limitar a 6 documentos para mantener consistencia
const limitedDocuments = computed(() => documents.slice(0, 6));
</script>

<style scoped>
.documents-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

.section-title {
  font-size: 2rem;
  text-align: center;
  color: #333;
  margin-bottom: 30px;
  font-weight: bold;
  border-bottom: 2px solid #eee;
  padding-bottom: 15px;
}

.documents-grid {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -15px;
}

.document-item {
  padding: 0 15px;
  margin-bottom: 25px;
  box-sizing: border-box;
}

.document-card {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.document-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 15px;
}

.document-date {
  font-size: 0.95rem;
  color: #555;
  font-weight: bold;
}

.document-type {
  font-size: 1rem;
  color: #333;
  font-weight: 600;
}

.document-number {
  font-size: 0.9rem;
  color: #666;
}

.download-btn {
  background: none;
  border: 1px solid #2c7be5;
  color: #2c7be5;
  padding: 8px 15px;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.2s;
  width: 100%;
  text-align: center;
}

.download-btn:hover {
  background-color: #2c7be5;
  color: white;
}

.more-documents-btn {
  display: block;
  width: 200px;
  margin: 30px auto 0;
  background: none;
  border: 1px solid #333;
  color: #333;
  padding: 10px 0;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.2s;
  text-align: center;
}

.more-documents-btn:hover {
  background-color: #333;
  color: white;
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
  
  .section-title {
    font-size: 1.8rem;
  }
  
  .document-date {
    font-size: 0.9rem;
  }
  
  .document-type {
    font-size: 0.95rem;
  }
  
  .more-documents-btn {
    width: 100%;
  }
}
</style>