import { ref } from 'vue';
import showError from '@/utils/showError';

export const useFetchData = () => {
  const loading = ref(false);

  const fetchData = async (serviceFunction, params = {}) => {
    const { success, data, msg } = await serviceFunction(params);
    if (success) {
      return data;
    } else {
      showError(msg);
      return null;
    }
  };

  return {
    loading,
    fetchData,
  };
};
