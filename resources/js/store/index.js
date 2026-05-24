import Vue from 'vue'
import Vuex from 'vuex'
import VuexReset from '@ianwalter/vuex-reset';
Vue.use(Vuex)

import createPersistedState from "vuex-persistedstate";
import { auth } from './modules/auth.store';
import { system } from './modules/system.store';
import { inventory } from './modules/inventory.store';
import { single } from './modules/single.store';
import { administration } from './modules/administration.store';

const dataState = createPersistedState({
    key: 'findMe',
    paths: ['auth']
});

export const store = new Vuex.Store({
    modules: {
        auth,
        system,
        inventory,
        single,
        administration,
    },
    plugins: [dataState, VuexReset()]
});