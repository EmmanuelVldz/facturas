<template>
  <v-overlay :model-value="loading" class="align-center justify-center">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>
</template>

<script setup>
defineProps({
  loading: Boolean, 
});
</script>
