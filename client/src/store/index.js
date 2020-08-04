import Vue from 'vue';
import Vuex from 'vuex';
import status from './modules/status';
import auth from './modules/auth';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: { status, auth },
    plugins: []
});
