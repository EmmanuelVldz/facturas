import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api/v1'
});

export default async function http({ method, url, data = null, params = null }) {
  try {
    const response = await api({ method, url, data, params });
    return { success: true, data: response.data };
  } catch (error) {
    const { response } = error;

    return {
      success: false,
      status: response?.status || 500,
      msg: response?.data?.message || 'Ocurrió un error inesperado',
      errors: response?.data?.errors || null
    };
  }
};
