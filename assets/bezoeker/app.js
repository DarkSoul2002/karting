import 'Bezoeker/styles/app.css';
import Vue from 'vue';
import router from './routes.js';
import App from 'Bezoeker/App.vue'

new Vue({
    el: '#app',
    router,
    render: (h) => h(App),
}).$mount('#app');