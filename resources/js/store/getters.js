export const getters = {
  GET_CURRENT_DIRECTORY: state => {
    return state.currentDirectory;
  },
  GET_DIRECTORY: state => {
    return state.directoryCollection;
  },
  GET_MOVE_DIRECTORY: state => {
    return state.moveDirectoryCollection;
  }
};
