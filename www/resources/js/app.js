
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { createApp } from 'vue';
import mitt from 'mitt';

const Vue = createApp({});

//Create global event bus
const eventBus = mitt();
Vue.config.globalProperties.eventBus = eventBus;


// Define Components
Vue.component('modal-popup', require('./components/common/ModalPopup.vue').default);    
Vue.component('modal-popup-root', require('./components/common/ModalPopupRoot.vue').default);
Vue.component('modal-submit-button', require('./components/ModalSubmitButton.vue').default);

Vue.component('role-create-button',   require('./components/RoleCreateButton').default);
Vue.component('role-edit-button',   require('./components/RoleEditButton').default);


// Mount te app
Vue.mount('#app');
