import Vue from "vue";
import VueI18n from "vue-i18n";
import store from "./store/store";
import VueToast from "vue-toast-notification";
import VueSimpleContextMenu from "vue-simple-context-menu";
import mediaManager from "./components/media-manager";
import "vue-toast-notification/dist/theme-sugar.css";
import "../sass/app.scss";

Vue.component("vue-simple-context-menu", VueSimpleContextMenu);

Vue.use(VueI18n);
Vue.use(VueToast);
Vue.use(require("vue-moment"));
function loadLocaleMessages() {
  const locales = require.context(
    "./locales",
    true,
    /[A-Za-z0-9-_,\s]+\.json$/i
  );
  const messages = {};
  locales.keys().forEach(key => {
    const matched = key.match(/([A-Za-z0-9-_]+)\./i);
    if (matched && matched.length > 1) {
      const locale = matched[1];
      messages[locale] = locales(key);
    }
  });
  return messages;
}

const i18n = new VueI18n({
  locale: "en",
  messages: loadLocaleMessages()
});

var mediamanager = document.getElementById('media-manager');

if(mediamanager)  {
    new Vue({
    store,
    VueToast,
    render: h => h(mediaManager, { props: { ...mediamanager.dataset }}),
    i18n
    }).$mount("#media-manager");
}
