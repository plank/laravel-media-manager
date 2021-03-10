import Vue from 'vue';
import Vuex from 'vuex';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueI18n from 'vue-i18n';

import { state } from './state';
import { actions } from './actions';
import { mutations } from './mutations';
import { getters } from './getters';

Vue.use(Vuex);
Vue.use(VueToast);
Vue.use(VueI18n);

const i18n = new VueI18n({});

export default new Vuex.Store({
  i18n,
  state,
  mutations,
  actions,
  getters
});
