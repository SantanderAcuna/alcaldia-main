const parseApiDate = (src: string | null): Date | null => {
  if (!src) return null; // null → null

  // Si ya incluye la “T”, asumimos ISO y delegamos a Date
  if (src.includes('T')) {
    const d = new Date(src);
    return isNaN(d.getTime()) ? null : d;
  }

  // Si llega solo YYYY-MM-DD → garantizamos LOCAL sin zona horaria
  const [y, m, d] = src.split('-').map(Number);
  const dateObj = new Date(y, m - 1, d);
  return isNaN(dateObj.getTime()) ? null : dateObj;
};

export default parseApiDate;
