// getDocumentAdmintActions.ts
export const getDocumentUrlAction = (
  documentPath: string | string[] | { path: string; nombre?: string }[] | null,
): string | Array<{ url: string; nombre?: string }> => {
  // 1️⃣ Si es null o undefined, retornar cadena vacía
  if (!documentPath) return '';

  const baseUrl = import.meta.env.VITE_API_BASE_URL ?? '';

  // 2️⃣ ───────── Si viene un array ─────────
  if (Array.isArray(documentPath)) {
    return documentPath
      .map((item) => {
        // Manejar diferentes formatos de entrada
        if (typeof item === 'string') {
          return {
            url: buildUrl(item, baseUrl),
            nombre: item.split('/').pop() || 'Documento',
          };
        } else if (item.path) {
          return {
            url: buildUrl(item.path, baseUrl),
            nombre: item.nombre || item.path.split('/').pop() || 'Documento',
          };
        }
        return { url: '', nombre: 'Documento inválido' };
      })
      .filter((item) => item.url); // Filtrar URLs vacías
  }

  // 3️⃣ ───────── Si viene una cadena simple ─────────
  return buildUrl(documentPath, baseUrl);
};

// Helper interno para construir URLs consistentes
const buildUrl = (rawPath: string, baseUrl: string): string => {
  if (!rawPath) return '';
  if (rawPath.startsWith('http')) return rawPath;

  // Limpiar path y construir URL completa
  const cleanPath = rawPath
    .replace(/^\/+/, '') // Quitar barras iniciales
    .replace(/^storage\//, '') // Quitar prefijo storage/
    .replace(/^planes\/documentos\//, ''); // Quitar prefijo planes/documentos/

  return `${baseUrl}/storage/${cleanPath}`;
};
