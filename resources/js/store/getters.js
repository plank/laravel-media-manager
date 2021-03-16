
export const getters = {
  GET_CURRENT_DIRECTORY: state => {
    return state.currentDirectory;
  },
  GET_DIRECTORY: state => {
    return state.directoryCollection;
  },
  getMoveDirectory: state => {
    return state.moveDirectoryCollection;
  }
};
