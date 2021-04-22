import 'Bezoeker/styles/app.css';
import Vue from 'vue';
import VueRouter from "vue-router";
import App from 'Bezoeker/App.vue'

new Vue({
    router: Routes,
    render: (h) => h(App),
}).$mount('#app')