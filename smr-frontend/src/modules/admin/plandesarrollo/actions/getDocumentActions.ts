import { apiConfig } from "@/api/apiConfig";


export const getDocumentUrlAction = (path: string | null): string => {
  if (!path) {
    console.warn('Intento de generar URL para documento sin path');
    return '#';
  }

  // Si el path ya es una URL completa, devolver directamente
  if (path.startsWith('http://') || path.startsWith('https://')) {
    return path;
  }

  // Construir URL basada en nuestro servidor
  // NOTA: El backend ya incluye "storage/" en la ruta de almacenamiento
  // pero no en la ruta de acceso, por lo que debemos mantener la estructura
  return `${apiConfig}/storage/${path}`;
};



