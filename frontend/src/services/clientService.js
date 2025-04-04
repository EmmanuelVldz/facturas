import http from '@/utils/http';

export const getClients = () =>
    http({ method: 'GET', url: '/client' });