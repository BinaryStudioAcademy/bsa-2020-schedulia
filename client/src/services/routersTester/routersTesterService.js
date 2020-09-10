import requestService from '@/services/requestService';
const USER_NICKNAME_URL = '/users';

const routersTesterService = {
    async checkNickname(nickname) {
        const response = await requestService.get(
            `${USER_NICKNAME_URL}/${nickname}`
        );
        return response;
    },

    async checkNicknameSlug(nickname, slug) {
        const response = await requestService.get(
            `${USER_NICKNAME_URL}/${nickname}/${slug}`
        );
        return response;
    }
};
export default routersTesterService;
