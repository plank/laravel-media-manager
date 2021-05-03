import Vue from 'vue';
import VueI18n from 'vue-i18n';
import MediaManager from './components/MediaManager';
import axios from 'axios';
import store from './store/store';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

// Context Menu
import VueSimpleContextMenu from 'vue-simple-context-menu';

import '../sass/app.scss';
Vue.component('vue-simple-context-menu', VueSimpleContextMenu);

Vue.prototype.$http = axios.create();
Vue.use(VueI18n);
Vue.use(VueToast);
Vue.use(require('vue-moment'));

// To Externalize In The Future
const messages = {
  en: {
    general: {
      title: 'Media Manager'
    },
    search: {
      input_placeholder: 'What are you looking for ? ',
      by_type: 'Filter by Type',
      by_date: 'Filter by Date',
      no_result: 'Sorry, no result'
    },
    actions: {
      delete: 'Delete',
      yes: 'Yes',
      no: 'No',
      create: 'Create',
      cancel: 'Cancel',
      move: 'Move',
      back: 'Back',
      copyToClipboard: 'Code Copy To Clipboard',
      more_details: 'More Details',
      createDirectory: 'Create Directory',
      viewGrid: 'View Grid',
      viewList: 'View List',
      search: 'Search',
      info: 'Informations',
      add_folder: 'Add Folder',
      created_on: 'Created on',
      error: 'Error',
      uploaded: 'Uploaded',
      updated: 'Updated',
      created: 'Created',
      deleted: 'Deleted',
      moved: 'Moved',
      deselectAll: 'Deselect All',
      empty_folder: 'This folder is empty',
      upload_text_click: 'Click',
      upload_text_here: 'here',
      upload_text_up: 'to upload files',
      drag_upload: 'Drag items here or add files',
      sort: {
        oldest: 'Sort Oldest to Newset',
        newest: 'Sort Newest to Oldest'
      }
    },
    slidepanel: {
      alt_text: 'Alternative Text',
      title: 'Title',
      source: 'Source',
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
      title_moveFolder: 'Move Item To :',
      confirmation_msg: 'Are you sure you want to delete this folder and all its items?',
      confirmation_msg_medias: 'Are you sure you want to delete this item?',
      confirmation_msg_medias_multiple: 'Are you sure you want to delete all these items? ',
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
      by_date: 'Filtrer par date',
      no_result: 'Désolé, aucun résultat'
    },
    actions: {
      delete: 'Effacer',
      yes: 'Oui',
      no: 'Non',
      create: 'Creer',
      cancel: 'Annuler',
      move: 'Déplacer',
      back: 'Retour',
      copyToClipboard: 'Code copier dans le presse-papiers',
      more_details: 'Details',
      createDirectory: 'Nouveau dossier',
      viewGrid: 'Grille',
      viewList: 'Liste',
      search: 'Chercher',
      add_folder: 'Ajouter Répertoire',
      info: 'Informations',
      created_on: 'Crée le',
      error: 'Erreur',
      upload: 'Téverser',
      updated: 'Mis à jour',
      created: 'Créer',
      deleted: 'Supprimer',
      moved: 'Déplacer',
      deselectAll: 'Tout déselectionner',
      empty_folder: 'Ce dossier est vide',
      upload_text_click: 'Clique',
      upload_text_here: 'ici',
      upload_text_up: 'pour téléverser un fichier',
      drag_upload: 'Faites glisser des éléments ici ou ajoutez des fichiers',
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
      title_moveFolder: 'Déplacer répertoire vers :',
      confirmation_msg: 'Êtes vous certains de vouloir supprimer ces éléments ?',
      confirmation_msg_medias: 'Êtes vous certains de vouloir supprimer cet élément ?',
      confirmation_msg_medias_multiple: 'Êtes vous certains de vouloir supprimer ces éléments ?',
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
  VueToast,
  render: h => h(MediaManager),
  i18n
}).$mount('#media-manager');
