import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './bezoeker/views/TheHome';
import Aanbod from './bezoeker/views/aanbod';
import Contact from './bezoeker/views/contact';

import Activiteiten from './deelnemer/views/activiteiten';
import UserProfileChange from './deelnemer/views/profilechange';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'home', component: Home },
        { path: '/aanbod', name: 'aanbod', component: Aanbod },
        { path: '/contact', name: 'contact', component: Contact },

        { path: '/deelnemer/activiteiten', name: 'activiteiten', component: Activiteiten },
        { path: '/user/profile/change', name: 'userprofilechange', component: UserProfileChange }
    ]
});

export default router;