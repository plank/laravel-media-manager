import Vue from 'vue';
import Vuex from 'vuex';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import { state } from './state';
import { actions } from './actions';
import { mutations } from './mutations';
import { getters } from './getters';

Vue.use(Vuex);
Vue.use(VueToast);

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters
});
