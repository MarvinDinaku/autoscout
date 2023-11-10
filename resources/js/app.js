import { createApp } from 'vue';
import LoginForm from './components/LoginForm.vue';
import RegisterForm from './components/RegistrationForm.vue';
import router from './router'; // Import your Vue Router configuration
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';

// Additional Bootstrap configuration code, if needed


createApp({})
    .use(router)
    .component('login-form', LoginForm)
    .component('register-form', RegisterForm)
    .mount('#app');
