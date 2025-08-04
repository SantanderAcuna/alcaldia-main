/**
 * Genera la URL completa para acceder a un documento
 * @param documentPath - Ruta relativa del documento
 * @returns URL completa como string
 * @throws Error si no se puede generar la URL
 */
export const getDocumentUrlAction = (documentPath: string): string => {
  if (!documentPath) {
    console.warn('Document path is empty');
    return '';
  }

  const baseUrl = import.meta.env.VITE_API_BASE_URL;
  if (!baseUrl) {
    console.error('VITE_API_BASE_URL no está definido');
    return '';
  }

  // Si ya es una URL completa, retornar directamente
  if (documentPath.startsWith('http')) {
    return documentPath;
  }

  try {
    // Limpiar la ruta y construir URL completa
    const cleanPath = documentPath
      .replace(/^planes\/documentos\//, '')
      .replace(/^storage\//, '')
      .trim();

    return `${baseUrl}/storage/planes/documentos/${cleanPath}`;
  } catch (error) {
    console.error('Error generating document URL:', error);
    return '';
  }
};
