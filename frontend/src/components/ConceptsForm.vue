<template>
  <div>
    <v-col cols="12" class="mb-2">
      <v-btn @click="addConcept" color="primary" variant="outlined">
        <v-icon start>mdi-plus</v-icon> Agregar concepto
      </v-btn>
    </v-col>

    <div v-for="(concepto, index) in conceptos" :key="index" class="mb-6">
      <v-row>
        <v-col cols="12" sm="6">
          <v-select
            v-model="concepto.ClaveProdServ"
            :items="products"
            label="Producto o Servicio"
            :rules="[v => !!v || 'Selecciona un producto o servicio']"
            required
          />
        </v-col>
        <v-col cols="12" sm="3">
          <v-text-field
            v-model="concepto.ClaveUnidad"
            label="Clave de Unidad"
            required
            readonly
          />
        </v-col>
        <v-col cols="12" sm="3">
          <v-text-field
            v-model="concepto.Unidad"
            label="Unidad"
            required
            readonly
          />
        </v-col>
        <v-col cols="12" sm="4">
          <v-text-field
            v-model="concepto.Cantidad"
            label="Cantidad"
            type="number"
            :rules="[v => v > 0 || 'Debe ser mayor a 0']"
            required
          />
        </v-col>
        <v-col cols="12" sm="4">
          <v-text-field
            v-model="concepto.ValorUnitario"
            label="Valor Unitario"
            type="number"
            :rules="[v => !!v || 'Requerido']"
            required
          />
        </v-col>
        <v-col cols="12" sm="4">
          <v-text-field
            :model-value="formatter.format(concepto.Cantidad * concepto.ValorUnitario)"
            label="Importe"
            readonly
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-text-field
            v-model="concepto.Descripcion"
            label="Descripción"
            :rules="[v => !!v || 'Requerido']"
            required
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-select
            v-model="concepto.ObjetoImp"
            :items="taxes"
            label="Objeto Impuesto"
            :rules="[v => !!v || 'Requerido']"
            required
          />
        </v-col>
        <v-col cols="12" class="d-flex justify-end">
          <v-btn
            icon
            color="error"
            @click="removeConcept(index)"
            v-if="conceptos.length > 1"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <v-divider class="mt-2 mb-1" />
    </div>

    <v-col cols="12" class="mb-3">
      <strong>Total de la factura:</strong> {{ total }}
    </v-col>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { formatter } from '@/utils/formatter';

const products = [
  { value: '43232408', title: 'Software de desarrollo de plataformas web' },
];

const taxes = [
  { value: '01', title: 'No objeto de impuesto' },
  { value: '02', title: 'Sí objeto de impuesto' },
  { value: '03', title: 'Objeto de impuesto no obligado al desglose' },
  { value: '04', title: 'Objeto de impuesto sin causar' }
];

const props = defineProps({
  conceptos: {
    type: Array,
    required: true
  }
});

const emit = defineEmits(['add-concept', 'remove-concept']);

const addConcept = () => emit('add-concept');
const removeConcept = (index) => emit('remove-concept', index);

const total = computed(() => {
  return formatter.format(
    props.conceptos.reduce((sum, item) => {
      const qty = parseFloat(item.Cantidad);
      const val = parseFloat(item.ValorUnitario);
      return sum + (isNaN(qty) || isNaN(val) ? 0 : qty * val);
    }, 0)
  );
});
</script>
