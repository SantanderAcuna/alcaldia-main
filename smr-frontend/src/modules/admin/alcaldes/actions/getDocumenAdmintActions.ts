// getDocumenAdmintActions.ts
export const getDocumentUrlAction = (
  documentPath: string | string[] | { path: string }[],
): string | string[] => {
  if (!documentPath) return '';

  const baseUrl = import.meta.env.VITE_API_BASE_URL ?? '';

  // 2️⃣ ───────── Si viene un **array** ─────────
  if (Array.isArray(documentPath)) {
    return documentPath.map((item) => {
      const raw = typeof item === 'string' ? item : item.path;
      return buildUrl(raw, baseUrl);
    });
  }

  // 3️⃣ ───────── Si viene una **cadena** ─────────
  return buildUrl(documentPath, baseUrl);
};

//  helper interno (no exportado) para evitar repetir código
const buildUrl = (rawPath: string, baseUrl: string): string => {
  if (rawPath.startsWith('http')) return rawPath;

  const cleanPath = rawPath.replace(/^planes\/documentos\//, '').replace(/^storage\//, '');

  return `${baseUrl}/storage/planes/documentos/${cleanPath}`;
};
