import 'primeicons/primeicons.css';
import 'primevue/resources/primevue.min.css';
import 'primevue/resources/themes/tailwind-light/theme.css';
import 'virtual:windi.css';
import '../css/app.scss';
import './bootstrap';

import { Icon } from '@iconify/vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import { createApp, h } from 'vue';
import Toast from 'vue-toastification';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createRouter, createWebHistory } from 'vue-router';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'K UI'

const toastificationOptions = {
    hideProgressBar: true,
    closeOnClick: false,
    closeButton: false,
    icon: false,
    timeout: 5000,
    transition: 'Vue-Toastification__fade',
};

const router = createRouter({
    history: createWebHistory(),
    routes: []
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(router)
            .use(PrimeVue)
            .use(ToastService)
            .use(Toast, toastificationOptions)
            .component('Iconify', Icon)
            .mount(el)
    },
})

InertiaProgress.init({ color: '#0ea5e9' })
