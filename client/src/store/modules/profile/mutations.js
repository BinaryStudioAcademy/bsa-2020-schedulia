import { UPDATE_BRANDING_LOGO } from './types/mutations';

export default {
    [UPDATE_BRANDING_LOGO]: (state, logo) => {
        state.brandingLogo = logo;
    }
};
