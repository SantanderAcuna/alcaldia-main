// getDocumentUrlAction.ts
export const getDocumentUrlAction = (documentPath: string): string => {
  if (!documentPath) return '';

  // Si ya es una URL completa, retórnala directamente
  if (documentPath.startsWith('http')) return documentPath;

  const baseUrl = import.meta.env.VITE_API_BASE_URL;
  if (!baseUrl) {
    console.error("VITE_API_BASE_URL no está definido en .env");
    return '';
  }

  // Elimina cualquier parte redundante de la ruta
  const cleanPath = documentPath
    .replace(/^planes\/documentos\//, '')
    .replace(/^storage\//, '');

  return `${baseUrl}/storage/planes/documentos/${cleanPath}`;
};
