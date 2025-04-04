import http from "@/utils/http";

export const getInvoices = (filters = {}) => {

  const params = Object.fromEntries(
    Object.entries(filters).filter(([key, value]) => value !== '' && value !== null && value !== undefined)
  );

  return http({ method: 'GET', url: '/invoice', params });
}

export const cancelInvoice = (uid, reason) =>
  http({ method: 'POST', url: `/invoice/${uid}`, data: { motivo: reason } });

export const sendInvoiceByEmail = (uid) =>
  http({ method: 'GET', url: `/invoice/${uid}` });

export const createInvoice = (data) =>
  http({ method: 'POST', url: '/invoice', data });
