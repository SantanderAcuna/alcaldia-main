<template>
  <div class="container-fluid py-4">
    <div class="editor-wrapper">
      <div class="editor-header">
        <div>
          <h2 class="mb-0"><i class="bi bi-newspaper"></i> Editor de Noticias</h2>
          <small class="opacity-75">Creando nueva publicación</small>
        </div>
        <div>
          <button class="btn btn-sm btn-outline-light me-2" @click="showPreview">
            <i class="bi bi-eye"></i> Vista previa
          </button>
          <button class="btn btn-sm btn-light me-2" @click="saveDraft">
            <i class="bi bi-save"></i> Guardar
          </button>
          <button class="btn btn-sm btn-success" @click="publishNews">
            <i class="bi bi-send-check"></i> Publicar
          </button>
        </div>
      </div>
      
      <div class="row g-0">
        <div class="col-md-8">
          <div class="editor-content">
            <div class="mb-4">
              <input 
                type="text" 
                class="form-control form-control-lg border-0 shadow-none fs-3" 
                placeholder="Título de la noticia" 
                v-model="news.title"
              >
            </div>
            
            <div class="mb-3">
              <input 
                type="text" 
                class="form-control border-0 shadow-none fs-5 text-muted" 
                placeholder="Subtítulo o entradilla" 
                v-model="news.subtitle"
              >
            </div>
            
            <!-- Editor principal -->
            <div ref="editorContainer"></div>
            
            <!-- Área de carga de medios -->
            <div class="mt-4">
              <h5><i class="bi bi-file-earmark-arrow-up"></i> Insertar multimedia</h5>
              <div class="media-upload-area" @click="triggerMediaUpload">
                <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                <p class="mt-2 mb-1">Arrastra archivos aquí o haz clic para seleccionar</p>
                <small class="text-muted">Formatos soportados: JPG, PNG, GIF, MP4, MP3, PDF, DOCX</small>
                <input 
                  type="file" 
                  ref="mediaUpload" 
                  multiple 
                  style="display: none;" 
                  accept="image/*, video/*, audio/*, .pdf, .doc, .docx" 
                  @change="handleMediaUpload"
                >
              </div>
              
              <div class="media-preview">
                <div v-for="(media, index) in uploadedMedia" :key="index" class="media-thumbnail">
                  <img :src="media.preview" :alt="media.name">
                  <span class="badge" :class="media.badgeClass">{{ media.type }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 sidebar">
          <div class="mb-4">
            <h5><i class="bi bi-gear"></i> Configuración</h5>
            <div class="mb-3">
              <label class="form-label">Estado</label>
              <select class="form-select" v-model="news.status" @change="toggleScheduleField">
                <option value="draft">Borrador</option>
                <option value="published">Publicado</option>
                <option value="scheduled">Programado</option>
              </select>
            </div>
            
            <div class="mb-3" v-show="showScheduleField">
              <label class="form-label">Fecha de publicación</label>
              <input type="datetime-local" class="form-control" v-model="news.publishDate">
            </div>
            
            <div class="mb-3">
              <label class="form-label">Categoría</label>
              <select class="form-select" v-model="news.category">
                <option value="">Seleccionar categoría</option>
                <option value="politica">Política</option>
                <option value="economia">Economía</option>
                <option value="tecnologia">Tecnología</option>
                <option value="cultura">Cultura</option>
                <option value="deportes">Deportes</option>
                <option value="internacional">Internacional</option>
              </select>
            </div>
          </div>
          
          <div class="mb-4">
            <h5><i class="bi bi-tags"></i> Etiquetas</h5>
            <div class="mb-3">
              <label class="form-label">Seleccionar etiquetas</label>
              <select 
                class="form-select" 
                multiple 
                v-model="selectedTagOptions" 
                @change="updateSelectedTags"
              >
                <option 
                  v-for="tag in availableTags" 
                  :key="tag.value" 
                  :value="tag.value"
                >
                  {{ tag.text }}
                </option>
              </select>
            </div>
            
            <div class="selected-tags">
              <span v-for="tag in news.tags" :key="tag" class="tag-item">
                {{ getTagName(tag) }} <i class="bi bi-x" @click="removeTag(tag)"></i>
              </span>
            </div>
          </div>
          
          <div class="mb-4">
            <h5><i class="bi bi-link"></i> Enlaces relacionados</h5>
            <div class="mb-3">
              <label class="form-label">Noticias relacionadas</label>
              <select class="form-select" v-model="news.relatedNews">
                <option value="">Seleccionar noticia relacionada</option>
                <option value="1">Últimas tendencias en diseño urbano</option>
                <option value="2">Nuevas regulaciones de vivienda en Brooklyn</option>
                <option value="3">El auge de los espacios de coworking</option>
              </select>
            </div>
          </div>
          
          <div class="mb-4">
            <h5><i class="bi bi-megaphone"></i> Compartir en redes</h5>
            <div class="form-check form-switch mb-2">
              <input class="form-check-input" type="checkbox" id="shareFacebook" v-model="news.socialShare.facebook">
              <label class="form-check-label" for="shareFacebook">Facebook</label>
            </div>
            <div class="form-check form-switch mb-2">
              <input class="form-check-input" type="checkbox" id="shareTwitter" v-model="news.socialShare.twitter">
              <label class="form-check-label" for="shareTwitter">Twitter</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="shareLinkedIn" v-model="news.socialShare.linkedin">
              <label class="form-check-label" for="shareLinkedIn">LinkedIn</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de vista previa -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Vista previa de la noticia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <article class="p-4">
              <h1>{{ news.title || 'Título de la noticia' }}</h1>
              <p class="lead">{{ news.subtitle || 'Subtítulo o entradilla de la noticia' }}</p>
              
              <div class="d-flex align-items-center mb-4">
                <div>
                  <div class="fw-bold">Por [Autor]</div>
                  <div class="text-muted small"><span>Hoy</span> · 5 min de lectura</div>
                </div>
              </div>
              
              <div v-html="editorContent || '<p>Contenido de la noticia...</p>'"></div>
            </article>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" @click="publishNews">
              <i class="bi bi-send-check"></i> Publicar ahora
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import Quill from 'quill'
import 'quill/dist/quill.snow.css'
import { Modal } from 'bootstrap'

// Estado reactivo
const news = ref({
  title: '',
  subtitle: '',
  body: '',
  category: '',
  tags: [],
  status: 'draft',
  publishDate: '',
  relatedNews: '',
  socialShare: {
    facebook: true,
    twitter: true,
    linkedin: false
  }
})

const showScheduleField = ref(false)
const editorContent = ref('')
const uploadedMedia = ref([])
const editorContainer = ref(null)
const quillEditor = ref(null)
const mediaUpload = ref(null)
const selectedTagOptions = ref([])

const availableTags = [
  { value: 'actualidad', text: 'Actualidad' },
  { value: 'exclusiva', text: 'Exclusiva' },
  { value: 'analisis', text: 'Análisis' },
  { value: 'entrevista', text: 'Entrevista' },
  { value: 'reportaje', text: 'Reportaje' },
  { value: 'opex', text: 'Opinión experta' },
  { value: 'investigacion', text: 'Investigación' }
]

// Métodos
const toggleScheduleField = () => {
  showScheduleField.value = news.value.status === 'scheduled'
}

const updateSelectedTags = () => {
  news.value.tags = [...selectedTagOptions.value]
}

const removeTag = (tagValue) => {
  news.value.tags = news.value.tags.filter(tag => tag !== tagValue)
  selectedTagOptions.value = selectedTagOptions.value.filter(opt => opt !== tagValue)
}

const getTagName = (tagValue) => {
  const tag = availableTags.find(t => t.value === tagValue)
  return tag ? tag.text : tagValue
}

const triggerMediaUpload = () => {
  mediaUpload.value.click()
}

const handleMediaUpload = (event) => {
  const files = event.target.files
  
  for (let i = 0; i < files.length; i++) {
    const file = files[i]
    const fileType = file.type.split('/')[0]
    const mediaItem = {
      name: file.name,
      type: '',
      preview: '',
      badgeClass: ''
    }
    
    if (fileType === 'image') {
      mediaItem.type = 'Imagen'
      mediaItem.badgeClass = 'bg-primary'
      const reader = new FileReader()
      reader.onload = (e) => {
        mediaItem.preview = e.target.result
        uploadedMedia.value.push({...mediaItem})
      }
      reader.readAsDataURL(file)
    } else if (fileType === 'video') {
      mediaItem.type = 'Video'
      mediaItem.preview = 'https://via.placeholder.com/120x80?text=Video'
      mediaItem.badgeClass = 'bg-danger'
      uploadedMedia.value.push(mediaItem)
    } else if (fileType === 'audio') {
      mediaItem.type = 'Audio'
      mediaItem.preview = 'https://via.placeholder.com/120x80?text=Audio'
      mediaItem.badgeClass = 'bg-success'
      uploadedMedia.value.push(mediaItem)
    } else {
      mediaItem.type = file.name.split('.').pop().toUpperCase()
      mediaItem.preview = 'https://via.placeholder.com/120x80?text=Documento'
      mediaItem.badgeClass = 'bg-secondary'
      uploadedMedia.value.push(mediaItem)
    }
  }
}

const showPreview = () => {
  editorContent.value = quillEditor.value.root.innerHTML
  const previewModal = new Modal(document.getElementById('previewModal'))
  previewModal.show()
}

const saveDraft = () => {
  news.value.body = quillEditor.value.root.innerHTML
  console.log('Borrador guardado:', news.value)
  alert('Borrador guardado exitosamente')
}

const publishNews = () => {
  news.value.body = quillEditor.value.root.innerHTML
  news.value.status = 'published'
  news.value.publishDate = new Date().toISOString()
  console.log('Noticia publicada:', news.value)
  alert('Noticia publicada exitosamente')
}

// Inicialización
onMounted(() => {
  nextTick(() => {
    quillEditor.value = new Quill(editorContainer.value, {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['link', 'image', 'video'],
          ['clean']
        ]
      },
      placeholder: 'Escribe aquí el contenido completo de tu noticia...',
    })
  })
})
</script>

<style scoped>
:root {
  --primary-color: #2c3e50;
  --secondary-color: #3498db;
  --dark-color: #2c3e50;
  --light-color: #ecf0f1;
  --success-color: #27ae60;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f8f9fa;
  color: #333;
}

.editor-wrapper {
  max-width: 1200px;
  margin: 20px auto;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  overflow: hidden;
}

.editor-header {
  background: var(--primary-color);
  color: white;
  padding: 15px 25px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.editor-content {
  padding: 25px;
}

.sidebar {
  background: #f8f9fa;
  padding: 20px;
  border-left: 1px solid #eee;
}

.ql-editor {
  min-height: 500px;
}

.media-upload-area {
  border: 2px dashed #ddd;
  border-radius: 8px;
  padding: 20px;
  text-align: center;
  margin-bottom: 20px;
  cursor: pointer;
  transition: all 0.3s;
}

.media-upload-area:hover {
  border-color: var(--secondary-color);
  background: rgba(52, 152, 219, 0.05);
}

.media-preview {
  margin-top: 15px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  gap: 10px;
}

.media-thumbnail {
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: hidden;
  position: relative;
}

.media-thumbnail img {
  width: 100%;
  height: 80px;
  object-fit: cover;
}

.media-thumbnail .badge {
  position: absolute;
  top: 5px;
  right: 5px;
  font-size: 10px;
}

.tag-item {
  display: inline-block;
  background: #e0e0e0;
  padding: 3px 8px;
  border-radius: 15px;
  margin-right: 5px;
  margin-bottom: 5px;
  font-size: 13px;
}

.tag-item .bi-x {
  cursor: pointer;
  margin-left: 3px;
}
</style>