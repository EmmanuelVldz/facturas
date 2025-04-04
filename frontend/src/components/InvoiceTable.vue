<template>
  <v-col cols="12">
    <div class="table-container">
      <v-table class="elevation-1" hover>
        <thead>
          <tr>
            <th class="font-weight-bold">Folio</th>
            <th class="font-weight-bold">Cliente</th>
            <th class="font-weight-bold">Total</th>
            <th class="font-weight-bold">Fecha</th>
            <th class="font-weight-bold">Estatus</th>
            <th class="font-weight-bold">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="invoice in invoices" :key="invoice.UID">
            <td>{{ invoice.Folio }}</td>
            <td>{{ invoice.RazonSocialReceptor }}</td>
            <td>{{ formatter.format(invoice.Total) }}</td>
            <td>{{ invoice.FechaTimbrado }}</td>
            <td>
              <v-chip :color="getStatusColor(invoice.Status)">
                {{ invoice.Status }}
              </v-chip>
            </td>
            <td>
              <v-row>
                <v-col cols="12" class="d-flex flex-column flex-sm-row align-stretch align-sm-start">
                  <v-btn color="red" class="mb-2 mb-sm-0 me-sm-2" @click="handleCancel(invoice)" size="small">
                    <v-icon start>mdi-file-cancel-outline</v-icon>Cancelar
                  </v-btn>
                  <v-btn color="blue-darken-1" @click="handleSend(invoice)" size="small">
                    <v-icon start>mdi-send</v-icon>Enviar
                  </v-btn>
                </v-col>
              </v-row>
            </td>
          </tr>
        </tbody>
      </v-table>
    </div>
  </v-col>
</template>

<script setup>
import { useCancelInvoice } from '@/composables/useCancelInvoice';
import { useSendInvoiceEmail } from '@/composables/useSendInvoiceEmail';
import { formatter } from '@/utils/formatter';

const props = defineProps({
  invoices: Array,
  formatter: Object,
});

const emit = defineEmits(['toggle-loading', 'update-invoices']);

const { cancelCfdi } = useCancelInvoice();
const { sendEmail } = useSendInvoiceEmail();

const changeLoading = (loading) => {
  emit('toggle-loading', loading);
};

const triggerFetchInvoices = () => {
  emit('update-invoices');
};

const handleCancel = async (invoice) => {
  await cancelCfdi(invoice, changeLoading, triggerFetchInvoices);
};

const handleSend = async (invoice) => {
  changeLoading(true);
  await sendEmail(invoice);
  changeLoading(false);
};

const getStatusColor = (status) => {
  if (status === 'enviada') return 'green';
  if (status === 'cancelada') return 'red';
  return 'grey';
};

</script>
