import { createApp } from 'vue'
import App from './App.vue'
import router from './router';
import 'vue-toast-notification/dist/theme-bootstrap.css';

createApp(App)
    .use(router)
    .mount('#app')
