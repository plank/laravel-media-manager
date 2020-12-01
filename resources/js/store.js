import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const state = { message: "Hello World" };
const getters = { message: state => state.message };
const store = new Vuex.Store({ state, getters });

export default store;
