import requestService from '@/services/requestService';
const USER_NICKNAME_URL = '/users';

const routersTesterService = {
    async checkNickname(nickname) {
        const response = await requestService.get(
            `${USER_NICKNAME_URL}/${nickname}`
        );
        return response;
    }
};
export default routersTesterService;
