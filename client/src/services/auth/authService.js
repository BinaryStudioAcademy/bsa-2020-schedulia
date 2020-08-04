import requestService from '@/services/requestService';

const authService = {
    async signIn(userLoginData) {
        return await requestService.post('/auth/login', userLoginData);
    },
    async signUp(userRegisterData) {
        return await requestService.post('/auth/register', userRegisterData);
    },
    async signOut() {
        return await requestService.post('/auth/logout');
    },
    async fetchLoggedUser() {
        return await requestService.get('/auth/me');
    }
};

export default authService;
