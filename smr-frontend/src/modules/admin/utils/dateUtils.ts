export const formatDateForBackend = (date: Date | string): string => {
  if (typeof date === 'string') date = new Date(date);
  return date.toISOString().split('T')[0];
};

export const parseApiDate = (dateString: string): Date => {
  return new Date(dateString + 'T00:00:00'); // Añade hora para evitar problemas de zona horaria
};
