import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    mainColor: '#9C1820',
    totalSelected: 0,
    modalState: false,
    viewState: false
  },

  getters: {
  },

  mutations: {
    addSelected (state) {
      state.totalSelected++;
    },
    openModal (state) {
      state.modalState = true;
    },
    closeModal (state) {
      state.modalState = false;
    },
    viewState (state, value) {
      state.viewState = value;
    }
  },

  actions: {
    addSelected (context) {
      context.commit('addSelected', 1);
    },

    openModal (context) {
      context.commit('openModal', true);
    },

    closeModal (context) {
      context.commit('closeModal', false);
    },

    viewState (context, value) {
      console.log(context);
      context.commit('viewState', value);
    },

    gridView (context) {
      context.commit('viewState', value);
    }
  }
});
