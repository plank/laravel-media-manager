// src/main.js
import Vue from 'vue';
import VueI18n from 'vue-i18n';
import App from './app';
import axios from 'axios';

import '../scss/main.scss';

Vue.prototype.$http = axios
Vue.use(VueI18n);

// To Externalize
const messages = {
    en: {
        general: {
            title: 'Media Manager'
        },
        search: {
            input_placeholder: 'What are you looking for? ',
            by_type: 'Filter by type',
            by_date: 'Filter by date',
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
            by_date: 'Filtrer par date',
        },
        slidepanel: {
            alt_text: 'Texte alternatif',
            credit: 'Crédit',
            caption: 'Légende'
        }
    }
}

const i18n = new VueI18n({
    locale: 'en',
    messages
});

new Vue({
    render: h => h(App),
    i18n
}).$mount('#app');

