import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    mainColor: '#9C1820',
    routeGetDirectory: '/media-api/index/',
    routeCreateDirectory: '/media-api/directory/create',
    routeDeleteDirectory: '/media-api/directory/destroy',
    currentDirectory: null,
    selectedDirectory: null,
    totalSelected: 0,
    modalState: {
      add: false,
      create: false,
      delete: false
    },
    folderState: true,
    viewState: false,
    selectedElem: [],
    directoryCollection: [],
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
    // directoryCollection: [
    //   { id: 1, directory: '/', directoryname: 'Name of the folder', created_at: 'July 31, 2020' },
    //   { id: 2, directory: '/s3', directoryname: 'Folder Name', created_at: 'July 31, 2020' }
    // ],
    mediaCollection: [],
    // mediaCollection: [
    //   { id: 1, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 2, disk: 's3', directory: '/', filename: 'video.mp4', extension: 'mp4', mime_type: 'video', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 3, disk: 's3', directory: '/', filename: 'audio.mp3', extension: 'mp3', mime_type: 'audio', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 4, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 5, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 6, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 7, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 8, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 9, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 10, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 11, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' },
    //   { id: 12, disk: 's3', directory: '/', filename: 'london_street.jpg', extension: 'jpg', mime_type: 'image', aggregate_type: '', size: '5676', created_at: 'July 31, 2020', updated_at: 'July 31, 2020' }
    // ]
  },

  getters: {
    getCurrentDirectory: state => {
      return state.currentDirectory;
    },
    getDirectory: state => {
      return state.directoryCollection;
    }
  },

  mutations: {
    closeModal (state) {
      state.modalState.create = false;
      state.modalState.delete = false;
    },
    openModalCreate (state) {
      state.modalState.create = true;
    },
    closeModalCreate (state) {
      state.modalState.create = false;
    },
    openModalDelete (state) {
      state.modalState.delete = true;
    },
    closeModalDelete (state) {
      state.modalState.delete = false;
    },
    openModalAdd (state) {
      state.modalState.add = true;
    },
    closeModalAdd (state) {
      state.modalState.add = false;
    },
    viewState (state, value) {
      state.viewState = value;
    },
    pushSelected (state, value) {
      state.selectedElem.push(value);
    },
    resetSelected (state, value) {
      state.selectedElem = [];
    },
    setActiveDirectory (state, value) {
      state.folderState = false;
    },
    SET_MEDIA (state, items) {
      console.log({state, items});
      state.mediaCollection = items;
    },
    SET_DIRECTORY (state, items) {
      state.directoryCollection = items;
    },
    SET_SELECTED_DIRECTORY (state, items) {
      state.selectedDirectory = items;
    }
  },

  actions: {
    closeModal (context) {
      context.commit('closeModalCreate', false);
      context.commit('closeModalDelete', false);
    },
    openModalCreate (context) {
      context.commit('openModalCreate', true);
    },
    closeModalCreate (context) {
      context.commit('closeModalCreate', false);
    },
    openModalDelete (context) {
      context.commit('openModalDelete', true);
    },
    closeModalDelete (context) {
      context.commit('closeModalDelete', false);
    },
    openModalAdd (context) {
      context.commit('openModalAdd', true);
    },
    closeModalAdd (context) {
      context.commit('closeModalAdd', false);
    },
    viewState (context, value) {
      context.commit('viewState', value);
    },
    gridView (context, value) {
      context.commit('viewState', value);
    },
    pushSelected (context, value) {
      const index = this.state.selectedElem.findIndex(item => item.id === value.id);

      if (index === -1) {
        this.state.selectedElem.push(value);
      } else {
        this.state.selectedElem.splice(index, 1);
      }
      // You can use this to debug purpose
      // console.log( this.state.selectedElem )
      this.state.totalSelected = this.state.selectedElem.length;
    },
    resetSelected (context, value) {
      context.commit('resetSelected', true);
      // Reset totalSelected value.
      this.state.totalSelected = this.state.selectedElem.length;
    },
    // Get all directory if no value passed or specific subdirectory
    // if we receive a value
    getDirectory ({ commit }, value) {
      let route;
      if (value) {
        this.state.currentDirectory = value;
        route = this.state.routeGetDirectory + value;
      } else {
        this.state.currentDirectory = '';
        route = this.state.routeGetDirectory;
      }
      axios
        .get(route, {})
        .then(response => {
          // if we have some media
          if (response.data.media) {
            commit('SET_MEDIA', response.data.media);
          }
          commit('SET_DIRECTORY', response.data.subdirectories);
        });
    },
    // Create Directory
    createDirectory ({ commit }, value) {
      axios
        .post(this.state.routeCreateDirectory + '?path=' + value, {})
        .then(response => {
          // Close Modal
          commit('closeModalCreate', true);
        });
    },
    deleteDirectory ({ commit }, value) {
      let route;
      if (value) {
        // this.state.currentDirectory = value;
        route = this.state.routeDeleteDirectory + '?path=' + value;
      } else {
        this.state.currentDirectory = '';
        route = this.state.routeDeleteDirectory;
      }
      axios
        .post(route, {})
        .then(response => {
          // commit('SET_DIRECTORY', response.data.subdirectories);
        });
    },
    // getMediaInDirectory ({ commit }, value) {
    // },
    // Set selected directory
    setSelectedDirectory (context, value) {
      context.commit('SET_SELECTED_DIRECTORY', value);
    }
  }
});
