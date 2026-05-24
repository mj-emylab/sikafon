import axios from 'axios';
import { store } from '../store';

// Create axios instance
const service = axios.create({
    baseURL: process.env.MIX_APP_URL,
    timeout: 120000,
    headers: {
        'Accepted': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
});

// Request intercepter
service.interceptors.request.use(
    config => {
        const token = store.getters['auth/getToken'];
        config.headers['Authorization'] = `Bearer ${token}`;
        return config;
    },
    error => {
        Promise.reject(error);
    }
);

// response pre-processing
service.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response.status === 401) {
            localStorage.removeItem('findMe');
            location.href = '/';
        }
        return Promise.reject(error);
    },
);

export default service;