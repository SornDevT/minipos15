import './bootstrap';


import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Menu from './Components/Menu.vue';

import { createPinia } from 'pinia';
const pinia = createPinia();

const app = createApp(App);
app.use(router);
app.use(pinia);
app.component('Menu',Menu);
app.mount('#app-vue');