require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import { InertiaProgress } from '@inertiajs/progress';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faWhatsapp } from '@fortawesome/free-brands-svg-icons'
import { faPlusSquare } from '@fortawesome/free-regular-svg-icons'
import { faMinusSquare } from '@fortawesome/free-regular-svg-icons'
import { faEdit } from '@fortawesome/free-regular-svg-icons'
import { faImage } from '@fortawesome/free-regular-svg-icons'
import { faUser } from '@fortawesome/free-regular-svg-icons'
import { faListAlt } from '@fortawesome/free-regular-svg-icons'
import { faTrashAlt } from '@fortawesome/free-regular-svg-icons'
import { faTimesCircle } from '@fortawesome/free-regular-svg-icons'
import { faArrowAltCircleLeft } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import VTooltip from 'v-tooltip'

library.add(faWhatsapp)
library.add(faPlusSquare)
library.add(faMinusSquare)
library.add(faEdit)
library.add(faImage)
library.add(faUser)
library.add(faListAlt)
library.add(faTrashAlt)
library.add(faTimesCircle)
library.add(faArrowAltCircleLeft)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.use(VTooltip)
Vue.use(PortalVue);

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);


const app = document.getElementById('app');

new Vue({
    mounted() {
        window.addEventListener('popstate', () =>{
            this.$page.popstate = true;
        });
    },
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);

InertiaProgress.init({ color: '#C7F0FF' });
