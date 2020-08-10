import Vue from 'vue';
import Vuex from 'vuex';
import status from './modules/status';
import auth from './modules/auth';
import profile from './modules/profile';
import snackbar from './modules/snackbar';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: { status, auth, profile, snackbar },
    plugins: []
});
