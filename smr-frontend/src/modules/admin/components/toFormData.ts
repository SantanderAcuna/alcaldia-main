/**
 * Convierte un objeto plano en FormData.
 * Acepta File, Blob, arrays y primitivos.
 * Ejemplo de uso:
 *   const fd = toFormData({ ...payload, foto_path: archivoImagen });
 */
// eslint-disable-next-line @typescript-eslint/no-explicit-any
export const toFormData = (obj: Record<string, any>): FormData => {
  const fd = new FormData();

  Object.entries(obj).forEach(([key, value]) => {
    if (value === undefined || value === null) return;

    if (Array.isArray(value)) {
      value.forEach((v, i) => fd.append(`${key}[${i}]`, v));
    } else {
      fd.append(key, value);
    }
  });

  return fd;
};
