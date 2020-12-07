import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    mainColor: '#9C1820',
    totalSelected: 0,
    modalState: false,
    viewState: false,
    selectedElem: [],
    dataType: [
      {
        id: 1,
        name: 'image'
      },
      {
        id: 2,
        name: 'video'
      }
    ],
    mediaCollection: [
      { id: 1, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 2, disk: 's3', directory: '/', filename: 'video.mp4', extension: 'mp4', mime_type: 'video', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 3, disk: 's3', directory: '/', filename: 'audio.mp3', extension: 'mp3', mime_type: 'audio', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 4, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 5, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 6, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 7, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 8, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 9, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 10, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 11, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' },
      { id: 12, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: '0454562', updated_at: '0454562' }
    ]
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
    },
    pushSelected (state, value) {
      state.selectedElem.push(value);
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
      context.commit('viewState', value);
    },

    gridView (context) {
      context.commit('viewState', value);
    },

    pushSelected (context, value) {
      context.commit('pushSelected', value);
    }
  }
});
