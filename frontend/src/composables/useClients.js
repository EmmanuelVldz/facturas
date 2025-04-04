import { ref, onMounted } from 'vue';
import { getClients } from '@/services/clientService';
import showError from '@/utils/showError';
import alphabeticalSort from '@/utils/sort';

export function useClients() {
  const clients = ref([]);
  const loadingClients = ref(false);

  const fetchClients = async () => {
    loadingClients.value = true;
    const { success, data, msg } = await getClients();

    if (success) {
      clients.value = data.data.sort(alphabeticalSort('RazonSocial'));
    } else {
      showError(msg);
    }
    loadingClients.value = false;
  };

  onMounted(fetchClients);

  return { clients, fetchClients, loadingClients };
}
