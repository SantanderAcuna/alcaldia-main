/**
 * 📂 getDocumentActions.ts
 *  Convierte cualquier forma de `document_path` en una URL(s) pública(s)
 *  lista(s) para el navegador.
 */
import type { DocumentPath, DocumentPathItem } from '@/modules/interfaces/planDesarrollointerfaces';

/**
 * Punto de entrada único.
 * @param documentPath Puede ser string, objeto o array.
 * @returns string | string[] – Siempre URL(s) absolutas(s) o ''.
 */
export const getDocumentUrlAction = (
  documentPath: DocumentPath | undefined | null,
): string | string[] => {
  if (!documentPath) return ''; // ← nulo, undefined o cadena vacía

  // 1️⃣ Array de objetos o strings
  if (Array.isArray(documentPath)) {
    return documentPath.map(
      (item) => buildUrl(extractPath(item)), // mantiene orden
    );
  }

  // 2️⃣ Objeto suelto
  if (isDocumentPathItem(documentPath)) {
    return buildUrl(documentPath.path);
  }

  // 3️⃣ Cadena simple
  return buildUrl(documentPath);
};

/* ------------------------------------------------------------------ */
/* 🛠️ Helpers                                                         */
/* ------------------------------------------------------------------ */

/** Comprueba si el valor es del tipo `{ path: string }`. */
const isDocumentPathItem = (value: unknown): value is DocumentPathItem =>
  typeof value === 'object' &&
  value !== null &&
  'path' in value &&
  typeof (value as DocumentPathItem).path === 'string';

/** Extrae la ruta de un ítem que puede ser objeto o string. */
const extractPath = (item: string | DocumentPathItem): string =>
  typeof item === 'string' ? item : item.path;

/**
 * Construye una URL absoluta limpia.
 * – Si ya viene absoluta (`http…`) se devuelve tal cual.
 * – Si viene relativa, se antepone `VITE_API_BASE_URL`.
 */
const buildUrl = (raw: string): string => {
  if (!raw) return '';

  // Ruta ya absoluta
  if (/^https?:\/\//i.test(raw)) return raw;

  const baseUrl = import.meta.env.VITE_API_BASE_URL?.replace(/\/+$/, '') ?? '';

  // El backend ya guarda la carpeta completa; evitamos duplicar
  const cleanPath = raw.replace(/^storage\/|^planes\/documentos\//, '');

  return `${baseUrl}/storage/planes/documentos/${cleanPath}`;
};
