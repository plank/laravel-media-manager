import axios from 'axios';

export const actions = {
  CLOSE_MODAL (context) {
    context.commit('CLOSE_MODAL_CREATE', false);
    context.commit('CLOSE_MODAL_DELETE', false);
    context.commit('CLOSE_MODAL_MOVE', false);
  },
  OPEN_MODAL_CREATE (context) {
    context.commit('OPEN_MODAL_CREATE', true);
  },
  CLOSE_MODAL_CREATE (context) {
    context.commit('CLOSE_MODAL_CREATE', false);
  },
  OPEN_MODAL_DELETE (context) {
    context.commit('OPEN_MODAL_DELETE', {
      modal_state: true
    });
  },
  CLOSE_MODAL_DELETE (context) {
    context.commit('CLOSE_MODAL_DELETE', false);
  },
  OPEN_MODAL_ADD (context) {
    context.commit('OPEN_MODAL_ADD', true);
  },
  CLOSE_MODAL_ADD (context) {
    context.commit('CLOSE_MODAL_ADD', false);
  },
  OPEN_MOVE_MODAL (context) {
    context.commit('OPEN_MODAL_MOVE', true);
  },
  CLOSE_MOVE_MODAL (context) {
    context.commit('CLOSE_MODAL_MOVE', false);
  },
  VIEW_STATE (context, value) {
    context.commit('VIEW_STATE', value);
  },
  GRID_VIEW (context, value) {
    context.commit('VIEW_STATE', value);
  },
  PUSH_SELECTED (context, value) {
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
  RESET_SELECTED (context, value) {
    context.commit('RESET_SELECTED', true);
    // Reset totalSelected value.
    this.state.totalSelected = this.state.selectedElem.length;
  },
  // Get all directory if no value passed or specific subdirectory
  // if we receive a value
  GET_DIRECTORY ({ commit }, value) {
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
        commit('SET_MEDIA', response.data.media);
        // Create Media Types List
        commit('SET_MEDIATYPES', response.data.media);
      }
      commit('SET_DIRECTORY', response.data.subdirectories);
    });
  },
  // Get Directory For Moving Files
  GET_MOVE_DIRECTORY ({ commit }, value) {
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
  CREATE_DIRECTORY ({ commit }, value) {
    axios
      .post(this.state.routeCreateDirectory + '?path=' + value.name, {})
      .then(response => {
        // Close Modal
        commit('CLOSE_MODAL_CREATE', true);
        value.vm.$toast.open({
          type: 'success',
          position: 'bottom-left',
          message: value.vm.$i18n.t('actions.created')
        });
        // Refresh Current View With New Folder
        this.dispatch('GET_DIRECTORY', this.state.currentDirectory);
      });
  },
  DELETE_SELECTED ({ commit }, value) {
    // If We Have Directory -> Delete
    if (value.folder) {
      let route;
      if (value.folder) {
        this.state.currentDirectory = value.folder;
        route = this.state.routeDeleteDirectory + '?path=' + value.folder.name;
      } else {
        this.state.currentDirectory = '';
        route = this.state.routeDeleteDirectory;
      }
      axios.post(route, {}).then(response => {
        commit('CLOSE_MODAL');
        this.dispatch('GET_DIRECTORY', response.data.parentFolder);
        value.vm.$toast.open({
          type: 'success',
          position: 'bottom-left',
          message: value.vm.$i18n.t('actions.deleted')
        });
      });
    }

    // If We Have Media Collection -> Delete
    if (value.mediaCollection) {
      this.dispatch('DELETE_SELECTED_MEDIAS', {
        vm: value.vm,
        media: value.mediaCollection
      });
    }
  },
  // Set selected directory
  SET_SELECTED_DIRECTORY (context, value) {
    context.commit('SET_SELECTED_DIRECTORY', value);
  },
  DELETE_SELECTED_MEDIAS ({ commit, context }, value) {
    const media = [];
    const promises = [];
    for (let i = 0; i < value.media.length; i++) {
      promises.push(
        axios
          .post(this.state.routeDeleteMedia, { id: value.media[i].id })
          .then(response => {
            value.vm.$toast.open({
              type: 'success',
              position: 'bottom-left',
              message: value.vm.$i18n.t('actions.deleted')
            });
            // do something with response
            media.push(response);
          })
      );
    }

    commit('CLOSE_MODAL');
    this.dispatch('GET_DIRECTORY', this.state.currentDirectory);

    Promise.all(promises).then(() => console.log());
  },
  MAKE_SEARCH ({ commit }, value) {
    axios
      .get(this.state.routeSearchMedia + '?q=' + value, {})
      .then(response => {
        // Replace Medias Collection With Results
        this.state.mediaCollection = response.data;
        this.state.hideDirectory = true;
        // Hide Folders
      });
  },
  UPDATE_ORDERBY ({ commit, state, dispatch }, data) {
    const directoryArray = Object.values(this.state.directoryCollection);
    const mediasArray = Object.values(this.state.mediaCollection);
    // Sort Medias
    this.state.mediaCollection = mediasArray.sort(function (value1, value2) {
      if (data === 'desc') {
        if (value1.timestamp > value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }

      if (data === 'asc') {
        if (value1.timestamp < value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }
    });

    // Sort Directories
    this.state.directoryCollection = directoryArray.sort(function (value1, value2) {
      if (data === 'desc') {
        if (value1.timestamp > value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }

      if (data === 'asc') {
        if (value1.timestamp < value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }
    });
  },
  UPDATE_MEDIA (context, value) {
    axios.post(this.state.routeUpdateMedia, {
      disk: value.disk,
      id: value.id,
      alt: value.alt,
      credit: value.credit,
      caption: value.caption
    }).then(response => {
      value.vm.$toast.open({
        type: 'success',
        position: 'bottom-left',
        message: value.vm.$i18n.t('actions.uploaded')
      });
      // Refresh folde to get real data on slidebar
      this.dispatch('GET_DIRECTORY', this.state.currentDirectory);
    });
  }

};
