import { UPDATE_BRANDING_LOGO, UPDATE_AVATAR } from './types/mutations';

export default {
    [UPDATE_BRANDING_LOGO]: (state, logo) => {
        state.brandingLogo = logo;
    },

    [UPDATE_AVATAR]: (state, avatar) => {
        state.avatar = avatar;
    }
};
