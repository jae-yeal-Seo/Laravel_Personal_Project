require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import mitt from 'mitt'
import MyWorry from '@/Pages/MyWorry';


const emitter = mitt();



const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
       const wApp = createApp({ render: () => h(app, props) })
        .use(plugin)
        .mixin({ methods: { route } })
        wApp.config.globalProperties.emitter = emitter;
        wApp.mount(el);
        return wApp;
    },
});

// InertiaProgress.init({ color: '#4B5563' });
