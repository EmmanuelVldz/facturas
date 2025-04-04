
<template>
  <LoadingOverlay :loading="loading || loadingClients" />
  <v-container>
    <v-row>
      <v-col cols="12">
        <h2>Listado de Facturas</h2>
      </v-col>

      <v-col cols="12" sm="6" class="py-1">
        <v-select v-model="filters.rfc" variant="solo-filled" :items="clients" item-title="RazonSocial" item-value="RFC"
          label="Buscar por Cliente" :disabled="clients.length == 0" clearable></v-select>
      </v-col>
      <v-col cols="12" sm="3" class="py-1">
        <v-select v-model="filters.per_page" variant="solo-filled" :items="[5, 10, 15, 20]"
          label="Registros por página" />
      </v-col>

      <template v-if="invoices.length > 0">
        <InvoiceTable :invoices="invoices" @toggle-loading="loading = $event"
          @update-invoices="fetchInvoices" />

        <v-col cols="12" class="d-flex justify-center">
          <v-pagination v-model="page" :length="totalPages" total-visible="3" variant="text"></v-pagination>
        </v-col>
      </template>

      <v-col cols="12" v-else>
        <v-alert type="info" variant="tonal">No hay facturas disponibles.</v-alert>
      </v-col>
    </v-row>
  </v-container>
</template>
<script setup>
import { ref, reactive, watch, onMounted } from 'vue';
import { getInvoices } from '@/services/invoiceService';
import { useFetchData } from '@/composables/useFetchData';
import InvoiceTable from '@/components/InvoiceTable.vue';
import LoadingOverlay from '@/components/LoadingOverlay.vue';
import { useClients } from '@/composables/useClients';

const invoices = ref([]);
const page = ref(1);
const totalPages = ref(1);

const filters = reactive({
  rfc: null,
  per_page: 10,
});

const { loading, fetchData } = useFetchData();

const fetchInvoices = async () => {
  loading.value = true;
  const data = await fetchData(getInvoices, { page: page.value, ...filters });
  loading.value = false;
  if (data) {
    invoices.value = data.data;
    totalPages.value = data.last_page;
  }
};

const {loadingClients, clients} = useClients();

onMounted(() => {
  fetchInvoices();
});
watch(() => filters.rfc, fetchInvoices);
watch(() => filters.per_page, fetchInvoices);
watch(() => page.value, fetchInvoices);

</script>
