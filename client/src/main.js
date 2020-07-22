import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import axios from 'axios';

Vue.config.productionTip = false;

(async () => {
    try {
        const response = await axios.get(
            process.env.VUE_APP_API_URL + '/api/status'
        );

        console.log(response.data);
    } catch (error) {
        console.error(error);
    }
})();

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');
