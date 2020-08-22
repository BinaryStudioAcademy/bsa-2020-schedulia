import axios from 'axios';
import authService from '@/services/auth/authService';

const API_URL = process.env.VUE_APP_API_URL;

axios.interceptors.request.use(
    config => {
        if (authService.getToken()) {
            config.headers[
                'Authorization'
            ] = `Bearer ${authService.getToken()}`;
        }
        return config;
    },
    error => Promise.reject(error)
);

axios.interceptors.response.use(
    response => response,
    error => {
        const allError = error?.response?.data?.error;

        const nextError = new Error(
                allError?.message || error
        );

        if(allError.validator) {
            const validatorError = new Object();

            for (let errorName in allError.validator) {
                validatorError[errorName] = allError.validator[errorName][0];
            }

            nextError.validatorError = validatorError;
        }

        nextError.response = error.response;
        return Promise.reject(nextError);
    }
);
const requestService = {
    get(url, params = {}, headers = {}) {
        return axios.get(API_URL + url, {
            params,
            headers
        });
    },
    post(url, body = {}, config = {}) {
        return axios.post(API_URL + url, body, config);
    },
    put(url, body = {}, config = {}) {
        return axios.put(API_URL + url, body, config);
    },
    delete(url, config = {}) {
        return axios.delete(API_URL + url, config);
    }
};

export default requestService;
