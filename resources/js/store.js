import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    mainColor: '#9C1820',
    routeGetDirectory: '/media-api/index/' /* Get All Directory */,
    routeCreateDirectory: '/media-api/directory/create' /* Create Folder */,
    routeDeleteDirectory: '/media-api/directory/destroy' /* Delete Folder */,
    routeDeleteMedia: '/media-api/destroy' /* Delete Media */,
    routeMoveDirectory: '/media-api/directory/update' /* Move Folder */,
    currentDirectory: null,
    selectedDirectory: null,
    totalSelected: 0,
    modalState: {
      add: false,
      create: false,
      delete: false,
      move: false
    },
    folderState: true,
    viewState: false,
    selectedElem: [],
    directoryCollection: [],
    moveDirectoryCollection: [],
    mediaTypeArray: [],
    mediaCollection: []
  },

  getters: {
    getCurrentDirectory: state => {
      return state.currentDirectory;
    },
    getDirectory: state => {
      return state.directoryCollection;
    },
    getMoveDirectory: state => {
      return state.moveDirectoryCollection;
    }
  },

  mutations: {
    closeModal (state) {
      state.modalState.create = false;
      state.modalState.delete = false;
      state.modalState.move = false;
    },
    openModalCreate (state) {
      state.modalState.create = true;
    },
    closeModalCreate (state) {
      state.modalState.create = false;
    },
    openModalDelete (state) {
      state.modalState.delete = state;
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
    openModalMove (state) {
      state.modalState.move = true;
    },
    closeModalMove (state) {
      state.modalState.move = false;
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
      state.mediaCollection = items;
    },
    SET_MEDIATYPES (state, items) {
      for (let i = 0; i < items.length; i++) {
        const index = this.state.mediaTypeArray.findIndex(
          item => item === items[i].aggregate_type
        );
        if (index === -1) {
          this.state.mediaTypeArray.push(items[i].aggregate_type);
        }
      }
    },
    SET_DIRECTORY (state, items) {
      state.directoryCollection = items;
    },
    SET_MOVE_DIRECTORY (state, items) {
      state.moveDirectoryCollection = items;
    },
    SET_SELECTED_DIRECTORY (state, items) {
      state.selectedDirectory = items;
    },
    DELETE_SELECTED_MEDIAS (state, items) {
      console.log('delete selected medias');
    }
  },
  actions: {
    closeModal (context) {
      context.commit('closeModalCreate', false);
      context.commit('closeModalDelete', false);
      context.commit('closeModalMove', false);
    },
    openModalCreate (context) {
      context.commit('openModalCreate', true);
    },
    closeModalCreate (context) {
      context.commit('closeModalCreate', false);
    },
    openModalDelete (context) {
      context.commit('openModalDelete', {
        modal_state: true
      });
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
    openMoveModal (context) {
      context.commit('openModalMove', true);
    },
    closeMoveModal (context) {
      context.commit('closeModalMove', false);
    },
    viewState (context, value) {
      context.commit('viewState', value);
    },
    gridView (context, value) {
      context.commit('viewState', value);
    },
    pushSelected (context, value) {
      const index = this.state.selectedElem.findIndex(
        item => item.id === value.id
      );

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
      // Reset Selected Directory
      this.state.selectedElem = [];
      if (value) {
        this.state.currentDirectory = value;
        route = this.state.routeGetDirectory + value;
      } else {
        this.state.currentDirectory = '';
        route = this.state.routeGetDirectory;
      }
      axios.get(route, {}).then(response => {
        // if we have some media
        if (response.data.media) {
          console.log(response.data.media);
          commit('SET_MEDIA', response.data.media);
          // Create Media Types List
          commit('SET_MEDIATYPES', response.data.media);
        }
        commit('SET_DIRECTORY', response.data.subdirectories);
      });
    },
    // Get Directory For Moving Files
    getMoveDirectory ({ commit }, value) {
      let route;
      if (value) {
        route = this.state.routeGetDirectory + value;
      } else {
        route = this.state.routeGetDirectory;
      }
      axios.get(route, {}).then(response => {
        commit('SET_MOVE_DIRECTORY', response.data.subdirectories);
      });
    },
    // Create Directory
    createDirectory ({ commit }, value) {
      axios
        .post(this.state.routeCreateDirectory + '?path=' + value, {})
        .then(response => {
          // Close Modal
          commit('closeModalCreate', true);
          // Refresh Current View With New Folder
          this.dispatch('getDirectory', this.state.currentDirectory);
        });
    },
    deleteSelected ({ commit }, value) {
      // If We Have Directory -> Delete
      if (value.folder) {
        let route;
        if (value.folder) {
          this.state.currentDirectory = value.folder;
          route = this.state.routeDeleteDirectory + '?path=' + value.folder;
        } else {
          this.state.currentDirectory = '';
          route = this.state.routeDeleteDirectory;
        }
        axios.post(route, {}).then(response => {
          commit('closeModal');
          this.dispatch('getDirectory', response.data.parentFolder);
        });
      }

      // If We Have Media Collection -> Delete
      if (value.mediaCollection) {
        this.dispatch('deleteSelectedMedias', value.mediaCollection);
      }
    },
    // Set selected directory
    setSelectedDirectory (context, value) {
      context.commit('SET_SELECTED_DIRECTORY', value);
    },
    deleteSelectedMedias ({ commit, context }, value) {
      const users = [];
      const promises = [];
      for (let i = 0; i < value.length; i++) {
        promises.push(
          axios
            .post(this.state.routeDeleteMedia, { id: value[i].id })
            .then(response => {
              // do something with response
              users.push(response);
            })
        );
      }

      commit('closeModal');
      this.dispatch('getDirectory', this.state.currentDirectory);

      Promise.all(promises).then(() => console.log());
    }
  }
});
