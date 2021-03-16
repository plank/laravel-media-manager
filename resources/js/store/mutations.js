export const mutations = {
  CLOSE_MODAL (state) {
    state.modalState.create = false;
    state.modalState.delete = false;
    state.modalState.move = false;
  },
  OPEN_MODAL_CREATE (state) {
    state.modalState.create = true;
  },
  CLOSE_MODAL_CREATE (state) {
    state.modalState.create = false;
  },
  OPEN_MODAL_DELETE (state) {
    state.modalState.delete = state;
  },
  CLOSE_MODAL_DELETE (state) {
    state.modalState.delete = false;
  },
  OPEN_MODAL_ADD (state) {
    state.modalState.add = true;
  },
  CLOSE_MODAL_ADD (state) {
    state.modalState.add = false;
  },
  OPEN_MODAL_MOVE (state) {
    state.modalState.move = true;
  },
  CLOSE_MODAL_MOVE (state) {
    state.modalState.move = false;
  },
  VIEW_STATE (state, value) {
    state.viewState = value;
  },
  PUSH_SELECTED (state, value) {
    state.selectedElem.push(value);
  },
  RESET_SELECTED (state, value) {
    state.selectedElem = [];
  },
  SET_ACTIVE_DIRECTORY (state, value) {
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
};
