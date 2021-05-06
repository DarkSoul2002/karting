import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('Bezoeker/views/TheHome'),
        },
        {
            path: '/aanbod',
            name: 'aanbod',
            component: () => import('Bezoeker/views/aanbod'),
        },
        {
            path: '/contact',
            name: 'contact',
            component: () => import('Bezoeker/views/contact'),
        }
    ]
});

export default router;