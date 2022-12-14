export const getters = {
  getCurrentDirectory: state => {
    return state.currentDirectory;
  },
  getDirectory: state => {
    return state.directoryCollection;
  },
  getMoveDirectory: state => {
    return state.moveDirectoryCollection;
  },
  getMediaArray: state => {
    return state.mediaCollection;
  },
};
