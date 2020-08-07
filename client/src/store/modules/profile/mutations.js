import { CHANGE_PASSWORD, UPDATE_BRANDING_LOGO } from './types/mutations';

export default {
    [CHANGE_PASSWORD]: (state, password) => {
        state.profile.password = password;
    },
    [UPDATE_BRANDING_LOGO]: (state, logo) => {
        state.profile.brandingLogo = logo;
    }
};
