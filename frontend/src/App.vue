<script setup>
</script>

<template>
  <v-app>
    <v-app-bar color="primary">
      <v-toolbar-title>Facturas</v-toolbar-title>
      <v-btn to="/" color="white">Listado de Facturas</v-btn>
      <v-btn to="/create" color="white">Crear CFDI</v-btn>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<style scoped></style>
