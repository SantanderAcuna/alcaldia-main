import type { Documento } from '@/modules/interfaces/documentoInterfaces';

/**
 * Genera URLs para documentos
 * @param documents - Puede ser Documento, array de Documentos o string
 * @returns string[] - Array de URLs absolutas
 */
export const getDocumentUrlAction = (
  documents: Documento | Documento[] | string | undefined | null,
): string[] => {
  if (!documents) return [];

  // Normalizar a array
  const docsArray = Array.isArray(documents) ? documents : [documents];

  return docsArray
    .map((doc) => {
      const path = typeof doc === 'string' ? doc : doc.path;
      return buildUrl(path);
    })
    .filter((url) => url !== '');
};

/**
 * Construye URL absoluta para un documento
 * @param rawPath - Ruta del documento
 * @returns string URL absoluta o string vacía
 */
const buildUrl = (rawPath: string): string => {
  if (!rawPath) return '';

  // Si ya es URL absoluta
  if (/^https?:\/\//i.test(rawPath)) return rawPath;

  const baseUrl = import.meta.env.VITE_API_BASE_URL?.replace(/\/+$/, '') ?? '';
  const cleanPath = rawPath.replace(/^storage\/|^planes\/documentos\//, '').replace(/\/+/g, '/');

  return `${baseUrl}/storage/planes/documentos/${cleanPath}`;
};
