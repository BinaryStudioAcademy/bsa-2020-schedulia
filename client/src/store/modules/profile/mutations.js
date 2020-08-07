import { CHANGE_PASSWORD } from './types/mutations';

export default {
    [CHANGE_PASSWORD]: (state, password) => {
        state.profile.password = password;
    }
};
