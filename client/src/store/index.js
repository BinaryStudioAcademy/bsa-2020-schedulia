import Vue from 'vue';
import Vuex from 'vuex';
import status from './modules/status';
import auth from './modules/auth';
import profile from './modules/profile';
import notification from './modules/notification';
import eventTypes from './modules/eventTypes';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: { status, auth, profile, notification, eventTypes },
    plugins: []
});
