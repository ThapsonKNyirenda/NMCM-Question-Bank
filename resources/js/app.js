import './bootstrap';
import '../css/app.css';
import './common';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import clickOutside from './customer-directives.js'

const appName = import.meta.env.VITE_APP_NAME || 'NMCM';

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import the fontawesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import {
    faUserSecret,
    faListCheck,
    faUserTag,
    faEye,
    faEyeSlash,
    faPencil,
    faClose,
    faXmark,
    faCertificate,
    faBackward,
    faSignature,
    faPenToSquare,
    faList,
    faPeopleGroup,

} from '@fortawesome/free-solid-svg-icons'

/* add icons to the library */
library.add(
    faPeopleGroup,
    faList,
    faPenToSquare,
    faUserSecret,
    faListCheck,
    faUserTag,
    faEye,
    faEyeSlash,
    faPencil,
    faClose,
    faXmark,
    faCertificate,
    faBackward,
    faSignature
)

createInertiaApp({
    title: (title) => `${title} - ${"NMCM"}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        requireComponents(app);
        app.use(plugin).use(ZiggyVue).directive('click-outside', clickOutside).component('font-awesome-icon', FontAwesomeIcon).mount(el);
        delete el.dataset.page;
    },
    progress: {
        color: '#4B5563',
    },
});
