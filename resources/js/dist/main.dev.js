"use strict";

var _vue = _interopRequireDefault(require("vue"));

var _vueI18n = _interopRequireDefault(require("vue-i18n"));

var _app = _interopRequireDefault(require("./app"));

var _axios = _interopRequireDefault(require("axios"));

var _store = _interopRequireDefault(require("./store"));

require("../scss/main.scss");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

// src/main.js
_vue["default"].prototype.$http = _axios["default"];

_vue["default"].use(_vueI18n["default"]); // To Externalize In The Future


var messages = {
  en: {
    general: {
      title: 'Media Manager'
    },
    search: {
      input_placeholder: 'What are you looking for? ',
      by_type: 'Filter by type',
      by_date: 'Filter by date'
    },
    actions: {
      "delete": 'Delete',
      createDirectory: 'Create Directory'
    },
    slidepanel: {
      alt_text: 'Alternative Text',
      credit: 'Credit',
      caption: 'Caption'
    }
  },
  fr: {
    general: {
      title: 'Gestionnaire de médias'
    },
    search: {
      input_placeholder: 'Que cherchez-vous?',
      by_type: 'Filtrer par type',
      by_date: 'Filtrer par date'
    },
    slidepanel: {
      alt_text: 'Texte alternatif',
      credit: 'Crédit',
      caption: 'Légende'
    }
  }
};
var i18n = new _vueI18n["default"]({
  locale: 'en',
  messages: messages
});
new _vue["default"]({
  store: _store["default"],
  render: function render(h) {
    return h(_app["default"]);
  },
  i18n: i18n
}).$mount('#app');