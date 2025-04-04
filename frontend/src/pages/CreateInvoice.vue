<template>
  <LoadingOverlay :loading="loadingClients || loading" />
  <v-container>
    <h2 class="mb-3">Crear CFDI</h2>

    <v-form ref="form" v-model="valid" @submit.prevent="handleSubmit">
      <v-row>
        <v-col cols="12">
          <h3 class="text-subtitle-1 font-weight-medium mb-2">Receptor</h3>
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="invoiceData.Receptor.UID"
            :items="clients"
            item-title="RazonSocial"
            item-value="UID"
            label="Cliente"
            :rules="[v => !!v || 'Selecciona un cliente']"
            required
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-text-field
            v-model="invoiceData.Receptor.ResidenciaFiscal"
            label="Residencia Fiscal"
          />
        </v-col>
      </v-row>

      <v-divider class="mb-3"></v-divider>

      <v-row>
        <v-col cols="12">
          <h3 class="text-subtitle-1 font-weight-medium mb-2">Datos Generales del CFDI</h3>
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="invoiceData.TipoDocumento"
            :items="[{ title: 'Factura', value: 'factura' }]"
            label="Tipo de Documento"
            :rules="[v => !!v || 'Selecciona uno']"
            required
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="invoiceData.UsoCFDI"
            :items="cfdiOptions"
            label="Uso de CFDI"
            :rules="[v => !!v || 'Uso de CFDI es obligatorio']"
            required
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="invoiceData.Serie"
            :items="[{ title: 'F', value: 15425 }]"
            label="Serie"
            :rules="[v => !!v || 'Serie es obligatoria']"
            required
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="invoiceData.FormaPago"
            :items="paymentOptions"
            label="Forma de Pago"
            :rules="[v => !!v || 'Forma de Pago es obligatoria']"
            required
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="invoiceData.MetodoPago"
            :items="methodOptions"
            label="Método de Pago"
            :rules="[v => !!v || 'Método de Pago es obligatorio']"
            required
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="invoiceData.Moneda"
            :items="currencyOptions"
            label="Moneda"
            :rules="[v => !!v || 'Moneda es obligatoria']"
            required
          />
        </v-col>
      </v-row>

      <v-divider class="mb-3"></v-divider>

      <v-row>
        <v-col cols="12">
          <h3 class="text-subtitle-1 font-weight-medium mb-2">Conceptos</h3>
        </v-col>

        <ConceptsForm
          :conceptos="invoiceData.Conceptos"
          @add-concept="addConcept"
          @remove-concept="removeConcept"
        />
      </v-row>

      <v-btn type="submit" color="primary" :disabled="!valid">
        Generar CFDI
      </v-btn>
    </v-form>
  </v-container>
</template>

<script setup>
import { ref, reactive } from 'vue';
import Swal from 'sweetalert2';
import { createInvoice } from '@/services/invoiceService';
import { useClients } from '@/composables/useClients';
import LoadingOverlay from '@/components/LoadingOverlay.vue';
import showError from '@/utils/showError';
import ConceptsForm from '../components/ConceptsForm.vue';

const valid = ref(false);
const form = ref(null);
const loading = ref(false);

const invoiceData = reactive({
  Receptor: {
    UID: '',
    ResidenciaFiscal: '',
  },
  TipoDocumento: '',
  Conceptos: [
    {
      ClaveProdServ: '',
      Cantidad: 1,
      ClaveUnidad: 'E48',
      Unidad: 'Unidad de servicio',
      ValorUnitario: '',
      Descripcion: '',
      ObjetoImp: '',
    },
  ],
  UsoCFDI: '',
  Serie: '',
  FormaPago: '',
  MetodoPago: '',
  Moneda: '',
});

const { loadingClients, clients } = useClients();

const cfdiOptions = [
  { value: 'G01', title: 'Adquisición de mercancías' },
  { value: 'G02', title: 'Devoluciones, descuentos o bonificaciones' },
  { value: 'G03', title: 'Gastos en general' },
];

const currencyOptions = ['MXN', 'USD'];

const paymentOptions = [
  { title: 'Efectivo', value: '01' },
  { title: 'Cheque nominativo', value: '02' },
  { title: 'Transferencia electrónica', value: '03' },
  { title: 'Tarjeta de crédito', value: '04' },
];

const methodOptions = [
  { value: 'PUE', title: 'Pago en una sola exhibición' },
  { value: 'PPD', title: 'Pago en parcialidades o diferido' },
];


const addConcept = () => {
  invoiceData.Conceptos.push({
    ClaveProdServ: '',
    Cantidad: 1,
    ClaveUnidad: 'E48',
    Unidad: 'Unidad de servicio',
    ValorUnitario: '',
    Descripcion: '',
    ObjetoImp: '',
  });
};

const removeConcept = (index) => {
  invoiceData.Conceptos.splice(index, 1);
};

const handleSubmit = async () => {
  if (!form.value.validate()) {
    return;
  } 

  loading.value = true;
  const { success, data, msg } = await createInvoice(invoiceData);
  loading.value = false;

  if (success) {
    Swal.fire('Éxito', data.message, 'success');
    form.value.reset();
    invoiceData.Conceptos = [
      {
        ClaveProdServ: '',
        Cantidad: 1,
        ClaveUnidad: 'E48',
        Unidad: 'Unidad de servicio',
        ValorUnitario: '',
        Descripcion: '',
        ObjetoImp: '',
      },
    ];
  } else {
    if(typeof msg === 'object' && 'message' in msg) {
      showError(msg.message);
      return;
    }
    showError(msg);
  }
};
</script>
