import './bootstrap.js';
import './styles/app.scss';

require('bootstrap');

import { createApp } from 'vue';
//import Example from './components/Example.vue';
import Calendar from './components/Calendar.vue';
//import CalendarLegend from './components/CalendarLegend.vue';

const app = createApp({
    components: {
        //Example,
        Calendar,
        //CalendarLegend,
    }
});

app.mount("#app");
