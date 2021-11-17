export const mutations = {
  CLOSE_MODAL(state) {
    state.modalState.create = false;
    state.modalState.delete = false;
    state.modalState.move = false;
  },
  OPEN_MODAL_CREATE(state) {
    state.modalState.create = true;
  },
  CLOSE_MODAL_CREATE(state) {
    state.modalState.create = false;
  },
  OPEN_MODAL_DELETE(state) {
    state.modalState.delete = state;
  },
  CLOSE_MODAL_DELETE(state) {
    state.modalState.delete = false;
  },
  OPEN_MODAL_ADD(state) {
    state.modalState.add = true;
  },
  CLOSE_MODAL_ADD(state) {
    state.modalState.add = false;
  },
  OPEN_MODAL_MOVE(state) {
    state.modalState.move = true;
  },
  CLOSE_MODAL_MOVE(state) {
    state.modalState.move = false;
  },
  VIEW_STATE(state, value) {
    state.viewState = value;
  },
  PUSH_SELECTED(state, value) {
    state.selectedElem.push(value);
  },
  RESET_SELECTED(state, value) {
    state.selectedElem = [];
  },
  SET_ACTIVE_DIRECTORY(state, value) {
    state.folderState = false;
  },
  SET_MEDIA(state, values) {
    console.log(values, "values inside SET_MEDIA mutation")
    if (values.media.length > 0) { // check for the value received if its empy clear the state
      let media = values.media;
      if (values.lazyLoad) { // check if the request is to lazyload and add to the array instead of reseting it with new values
        //for some reason i couldnt spread ... so i just did this instead
        media.map(item => state.mediaCollection.push(item));
      } else {
        state.mediaCollection = media;
      }
    } else {
      state.mediaCollection = [];
    }
    
    //handle what happens when all media is loaded
    if(values.currentPage == values.pageCount) {
      state.allMediaLoaded = true;
    }
  },
  UPDATE_MEDIA_VALUE(state, { id, value }) {
    const mediaElement = state.mediaCollection.find(q => q.id === value.id);
    mediaElement.credit = value.credit;
    mediaElement.title = value.title;
    mediaElement.alt = value.alt;
    mediaElement.caption = value.caption;
  },
  SET_MEDIATYPES(state, items) {
    for (let i = 0; i < items.length; i++) {
      const index = this.state.mediaTypeArray.findIndex(
        item => item === items[i].aggregate_type
      );
      if (index === -1) {
        this.state.mediaTypeArray.push(items[i].aggregate_type);
      }
    }
  },
  SET_DIRECTORY(state, items) {
    state.directoryCollection = items;
  },
  SET_MOVE_DIRECTORY(state, items) {
    state.moveDirectoryCollection = items;
  },
  SET_SELECTED_DIRECTORY(state, items) {
    state.selectedDirectory = items;
  },
  DELETE_SELECTED_MEDIAS(state, items) {
    console.log("delete selected medias");
  },
  SET_LANG(state, value) {
    state.lang = value;
  },
  SET_PAGE_COUNT(state, value) {
    state.pageCount = value;
  },
};
