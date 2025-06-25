// getImageAction.ts
export const getImageAction = (imagePath: string): string => {
  if (!imagePath) return '';

  // Si ya es una URL completa, retórnala directamente
  if (imagePath.startsWith('http')) return imagePath;

  const baseUrl = import.meta.env.VITE_API_BASE_URL;
  if (!baseUrl) {
    console.error("VITE_API_BASE_URL no está definido en .env");
    return '';
  }

  // Elimina cualquier parte redundante de la ruta
  const cleanPath = imagePath
    .replace(/^alcaldes\/fotos\//, '')
    .replace(/^storage\//, '');

  return `${baseUrl}/storage/alcaldes/fotos/${cleanPath}`;
};
