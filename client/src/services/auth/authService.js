import requestService from '@/services/requestService';
import axios from 'axios';

const authService = {
    async signIn(userLoginData) {
        const response = await requestService.post(
            '/auth/login',
            userLoginData
        );
        this.saveToken(response?.data?.data.access_token);
        return response?.data?.data;
    },
    async signUp(userRegisterData) {
        return await requestService.post('/auth/register', userRegisterData);
    },
    async forgotPassword(forgotEmail) {
        const myInterceptor = axios.interceptors.response.use(function() {
            /*...*/
        });
        axios.interceptors.response.eject(myInterceptor);
        const response = await requestService.post(
            '/auth/forgot-password',
            forgotEmail
        );
        return response;
    },
    async resetPassword(dataPasswordReset) {
        const response = await requestService.post(
            '/auth/reset-password',
            dataPasswordReset
        );
        return response;
    },
    async signOut() {
        const response = await requestService.post('/auth/logout');
        this.removeToken();
        return response?.data?.data;
    },
    async fetchLoggedUser() {
        const response = await requestService.get('/auth/me');
        return response?.data?.data;
    },
    saveToken(token) {
        localStorage.setItem('auth.accessToken', token);
    },
    removeToken() {
        localStorage.setItem('auth.accessToken', '');
    },
    getToken() {
        return localStorage.getItem('auth.accessToken');
    },
    hasToken() {
        return !!localStorage.getItem('auth.accessToken');
    },

    async verifyEmail(payload) {
        const response = await requestService.post(
            '/auth/email/verify',
            payload
        );
        return response?.data?.data;
    }
};

export default authService;
