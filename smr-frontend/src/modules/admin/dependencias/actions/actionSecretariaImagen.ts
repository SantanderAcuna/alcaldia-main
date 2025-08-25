// getImageAction.ts
export const getImageAction = (imagePath: string | undefined) => {
  if (!imagePath) return '';

  // Si ya es una URL completa, retórnala directamente
  if (imagePath.startsWith('http')) return imagePath;

  const baseUrl = import.meta.env.VITE_API_BASE_URL;
  if (!baseUrl) {
    console.error('VITE_API_BASE_URL no está definido en .env');
    return '';
  }

  // Elimina cualquier parte redundante de la ruta
  const cleanPath = imagePath.replace(/^secretaria\/fotos\//, '').replace(/^storage\//, '');

  return `${baseUrl}/storage/secretaria/fotos/${cleanPath}`;
};
