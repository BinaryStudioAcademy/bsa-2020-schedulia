import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary:
                    '#281AC8' /*from figma  dark background and primary text*/,
                secondary: '#F9F9F9' /*from figma light background*/,
                accent: '#18A0FB' /*from figma maybe should to shange */,
                error: '#FF3E1D' /*from figma  red*/,
                info: '#8B90A0' /*from figma  dark background and info text*/,
                success: '#4CAF50' /*standard*/,
                warning: '#FFD67A' /*standard*/
            }
        }
    }
});
