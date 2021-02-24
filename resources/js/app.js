import Vue from 'vue';
import VueI18n from 'vue-i18n';
import MediaManager from './components/MediaManager';
import axios from 'axios';
import store from './store';

import '../sass/app.scss';

Vue.prototype.$http = axios.create();
Vue.use(VueI18n);
Vue.use(require('vue-moment'));

// To Externalize In The Future
const messages = {
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
      delete: 'Delete',
      yes: 'Yes',
      no: 'No',
      create: 'Create',
      cancel: 'Cancel',
      createDirectory: 'Create Directory',
      viewGrid: 'View Grid',
      viewList: 'View List',
      search: 'Search',
      created_on: 'Created on',
      sort: {
        oldest: 'Sort Oldest to Newset',
        newest: 'Sort Newest to Oldest'
      }
    },
    slidepanel: {
      alt_text: 'Alternative Text',
      credit: 'Credit',
      caption: 'Caption'
    },
    carousel: {
      title: 'Create Carousel',
      selected_items: 'Item(s) Selected',
      drag_text: 'Drag photo to reorder',
      btn_create: 'Create',
      btn_cancel: 'Cancel'
    },
    modal: {
      title_createFolder: 'Create Folder',
      title_deleteFolder: 'Delete Folder',
      confirmation_msg: 'Are you sure you want to delete these items?',
      folder_name: 'Folder Name'
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
    actions: {
      delete: 'Effacer',
      yes: 'Oui',
      no: 'Non',
      create: 'Creer',
      cancel: 'Annuler',
      createDirectory: 'Nouveau dossier',
      viewGrid: 'Grille',
      viewList: 'Liste',
      search: 'Chercher',
      created_on: 'Crée le',
      sort: {
        oldest: 'Sort Oldest to Newset',
        newest: 'Sort Newest to Oldest'
      }
    },
    slidepanel: {
      alt_text: 'Texte alternatif',
      credit: 'Crédit',
      caption: 'Légende'
    },
    carousel: {
      title: 'Créer carousel',
      selected_items: 'Élément(s) Selectionnés',
      drag_text: 'Faites glisser la photo pour réorganiser',
      btn_create: 'Créer',
      btn_cancel: 'Annuler'
    },
    modal: {
      title_createFolder: 'Créer un dossier',
      title_deleteFolder: 'Supprimer répertoire',
      confirmation_msg: 'Êtes vous certains de vouloir supprimer ces éléments ?',
      folder_name: 'Nom du dossier'
    }
  }
};

const i18n = new VueI18n({
  locale: 'en',
  messages
});

new Vue({
  store,
  render: h => h(MediaManager),
  i18n
}).$mount('#media-manager');
