export const state = {
  mainColor: '#9C1820',
  routeGetDirectory: '/media-api/index/' /* Get All Directory */,
  routeCreateDirectory: '/media-api/directory/create' /* Create Folder */,
  routeDeleteDirectory: '/media-api/directory/destroy' /* Delete Folder */,
  routeDeleteMedia: '/media-api/destroy' /* Delete Media */,
  routeMoveDirectory: '/media-api/directory/update' /* Move Folder */,
  routeSearchMedia: '/media-api/search' /* Search Media */,
  hideDirectory: false,
  currentDirectory: null,
  selectedDirectory: null,
  searchResults: null,
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
  mediaCollection: [],
  // Ordering
  orderBy: 'created_at',
  orderDirection: 'asc'
};
