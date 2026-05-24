window.Vue = require('vue').default;

// require('./bootstrap');
require('./helpers/functions');

import Vue from 'vue';
import router from './route';
import Swal from 'sweetalert2';
import vSelect from 'vue-select';
import Loading from 'vue-loading-overlay';
import { store } from './store'
import 'vue-loading-overlay/dist/vue-loading.css';

//
import VueFileAgent from 'vue-file-agent';
import VueFileAgentStyles from 'vue-file-agent/dist/vue-file-agent.css';
Vue.use(VueFileAgent);

//Enable resumable
// import tus from 'tus-js-client';
// import { plugins } from 'vue-file-agent';
// plugins.tus = tus;

//files can be drag sorted
import { SlickList, SlickItem } from 'vue-slicksort';

Vue.component('vfa-sortable-list', SlickList);
Vue.component('vfa-sortable-item', SlickItem);


//

import Vuelidate from 'vuelidate';

import DatePicker from 'vue2-datepicker';
import VueTelInput from 'vue-tel-input';
import printData from 'print-js';
import VueHtmlToPaper from 'vue-html-to-paper';

import 'vue-loading-overlay/dist/vue-loading.css';
import 'vue2-datepicker/index.css';
// import 'vue-select/dist/vue-select.css';
import 'vue-tel-input/dist/vue-tel-input.css';

import 'vue-select/dist/vue-select.css';

import * as VueGoogleMaps from 'vue2-google-maps';

const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=no',
        // 'width=1100px',
        // 'height=800px',
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',
        'https://unpkg.com/kidlat-css/css/kidlat.css'
    ],
    timeout: 1000, // default timeout before the print window appears
    autoClose: false, // if false, the window will not close after printing
    windowTitle: "Workorder Print Out", // override the window title
}


window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
});


// Global registration
window.Toast = Toast;
window.Fire = new Vue();
window.printJSData = printData;


//vue good table
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'
Vue.use(VueGoodTablePlugin);
Vue.use(Vuelidate);
Vue.use(DatePicker);
Vue.use(VueTelInput);


//

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

Vue.component('vue-phone-number-input', VuePhoneNumberInput);

//


Vue.use(VueHtmlToPaper, options);

// Global registration of components
Vue.component("v-select", vSelect);
Vue.component("loading", Loading);

// Google map registration
Vue.use(VueGoogleMaps, {
    load: {
        // key: 'AIzaSyA8sFDujn-xj-pZk0ueSVCtvN5AoPu7HRU',
        key: 'AIzaSyA1TIMjDTjVUPm4cRKqWmczVWEzP775hAw',
        libraries: 'places',
    }
});

// Handle user permissions globally
Vue.mixin({
    data() {
        return {
            get authPermissions() {
                return store.getters['auth/permissions'];
            },
            get authUser() {
                return store.getters['auth/user'];
            },
            get authRole() {
                let user = store.getters['auth/user'];
                if (!user) {
                    return "";
                }
                return user.role ? user.role[0] : "";
            }
        }
    },
    methods: {
        can(key) {
            const userPermissions = store.getters['auth/permissions'];
            return userPermissions ? userPermissions.includes(key) : "";
        }
    },
});

const app = new Vue({
    el: '#app',
    router,
    store,
});