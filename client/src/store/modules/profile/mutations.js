import {
    UPDATE_USER,
    UPDATE_BRANDING_LOGO,
    UPDATE_AVATAR
} from './types/mutations';

export default {
    [UPDATE_USER]: (state, data) => {
        state.user = { ...state.user, ...data };
    },

    [UPDATE_BRANDING_LOGO]: (state, logo) => {
        state.brandingLogo = logo;
    },

    [UPDATE_AVATAR]: (state, avatar) => {
        state.avatar = avatar;
    }
};
