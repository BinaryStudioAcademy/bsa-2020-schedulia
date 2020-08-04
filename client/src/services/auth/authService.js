import requestService from '@/services/requestService';

const authService = {
    async signIn(userLoginData) {
        try {
            const response = await requestService.post(
                '/auth/login',
                userLoginData
            );
            this.saveToken(response.access_token);
            return response;
        } catch (error) {
            return Promise.reject(error);
        }
    },
    async signUp(userRegisterData) {
        return await requestService.post('/auth/register', userRegisterData);
    },
    async signOut() {
        try {
            const response = await requestService.post('/auth/logout');
            this.removeToken();
            return response;
        } catch (error) {
            return Promise.reject(error);
        }
    },
    async fetchLoggedUser() {
        return await requestService.get('/users/me');
    },
    saveToken(token) {
        localStorage.setItem('auth.accessToken', token);
    },
    removeToken() {
        localStorage.setItem('auth.accessToken', '');
    },
    getToken() {
        return localStorage.getItem('auth.accessToken');
    }
};

export default authService;
