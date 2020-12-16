import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store({
  state: {
    mainColor: '#9C1820',
    totalSelected: 0,
    modalState: false,
    folderState: true,
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
    directoryCollection: [
      { id: 1, directory: '/', directoryname: 'Name of the folder', created_at: 'July 31, 2020' },
      { id: 2, directory: '/s3', directoryname: 'Folder Name', created_at: 'July 31, 2020' }
    ],
    mediaCollection: [
      { id: 1, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 2, disk: 's3', directory: '/', filename: 'video.mp4', extension: 'mp4', mime_type: 'video', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 3, disk: 's3', directory: '/', filename: 'audio.mp3', extension: 'mp3', mime_type: 'audio', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 4, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 5, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 6, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 7, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 8, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 9, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 10, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 11, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
      { id: 12, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' }
    ]
  },

  getters: {
  },

  mutations: {

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
    },
    activeDirectory (state, value) {
      state.folderState = false;
    },
  },

  actions: {

    openModal (context) {
      context.commit('openModal', true);
    },

    closeModal (context) {
      context.commit('closeModal', false);
    },

    viewState (context, value) {
      context.commit('viewState', value);
    },

    gridView (context, value) {
      context.commit('viewState', value);
    },

    pushSelected (context, value) {
      const index = this.state.selectedElem.findIndex(item => item.id === value.id);

      if (index == -1) {
        this.state.selectedElem.push(value);
      } else {
        this.state.selectedElem.splice(index, 1);
      }
      // You can use this to debug purpose
      // console.log( this.state.selectedElem )

      this.state.totalSelected = this.state.selectedElem.length;
    },

    activeDirectory (context, value) {
      context.commit('activeDirectory', value);
    }
  }
});
