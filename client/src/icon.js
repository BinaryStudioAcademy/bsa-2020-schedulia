import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCaretDown } from '@fortawesome/free-solid-svg-icons';

library.add(faCaretDown);
Vue.component('FaIcon', FontAwesomeIcon);
