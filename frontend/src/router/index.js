import { createRouter, createWebHistory } from 'vue-router';
import CreateInvoice from '@/pages/CreateInvoice.vue';
import InvoiceList from '@/pages/InvoiceList.vue';

const routes = [
  { path: '/', component: InvoiceList },
  { path: '/create', component: CreateInvoice },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
