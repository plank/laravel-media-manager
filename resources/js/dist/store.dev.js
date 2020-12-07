"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vue = _interopRequireDefault(require("vue"));

var _vuex = _interopRequireDefault(require("vuex"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

_vue["default"].use(_vuex["default"]);

var _default = new _vuex["default"].Store({
  state: {
    mainColor: '#9C1820',
    totalSelected: 0,
    modalState: false,
    viewState: false,
    dataType: [{
      id: 1,
      name: 'image'
    }, {
      id: 2,
      name: 'video'
    }],
    mediaCollection: [{
      id: 1,
      name: 'london_street.jpg',
      type: 'image',
      upload_date: 'July 17, 2020'
    }, {
      id: 2,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }, {
      id: 3,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }, {
      id: 4,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }, {
      id: 5,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }, {
      id: 6,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }, {
      id: 7,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }, {
      id: 8,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }, {
      id: 9,
      name: 'audio_clip.mp3',
      type: 'audio',
      upload_date: 'July 17, 2020'
    }]
  },
  getters: {},
  mutations: {
    addSelected: function addSelected(state) {
      state.totalSelected++;
    },
    openModal: function openModal(state) {
      state.modalState = true;
    },
    closeModal: function closeModal(state) {
      state.modalState = false;
    },
    viewState: function viewState(state, value) {
      state.viewState = value;
    }
  },
  actions: {
    addSelected: function addSelected(context) {
      context.commit('addSelected', 1);
    },
    openModal: function openModal(context) {
      context.commit('openModal', true);
    },
    closeModal: function closeModal(context) {
      context.commit('closeModal', false);
    },
    viewState: function viewState(context, value) {
      console.log(context);
      context.commit('viewState', value);
    },
    gridView: function gridView(context) {
      context.commit('viewState', value);
    }
  }
});

exports["default"] = _default;