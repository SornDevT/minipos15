import './bootstrap';


import { createApp } from 'vue';
import App from './App.vue';
import router from './Router';
import Menu from './Components/Menu.vue';
import Pagination from './Components/Pagination.vue';
import Cleave from 'vue-cleave-component';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar';
import 'vue3-perfect-scrollbar/style.css';

import { createPinia } from 'pinia';
const pinia = createPinia();

const app = createApp(App);
app.use(PerfectScrollbarPlugin)
app.use(VueSweetalert2);
app.use(Cleave);
app.use(router);
app.use(pinia);
app.component('Menu',Menu);
app.component('Pagination',Pagination);
app.mount('#app-vue');