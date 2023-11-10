<template>
    <div class="login-container">
        <div class="login-box">
            <h2 class="text-center">Login</h2>
            <form @submit.prevent="login" class="login-form">
                <div class="mb-3">
                    <input v-model="email" type="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input v-model="password" type="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div v-if="loginError" class="alert alert-danger mt-3">{{ loginError }}</div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            loginError: null,
        };
    },
    methods: {
        login() {
            axios.post('/login', {
                email: this.email,
                password: this.password,
            }, {
                withCredentials: true, // Important for sending cookies
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
            })
                .then(response => {
                    console.log('Logged in successfully', response.data);

                    // Check if the user is an admin
                    if (response.data.role == 'admin') {
                        // Redirect the admin to the admin page
                        this.$router.push({ name: 'admin-page' });
                        window.location.href = '/admin';
                    } else {
                        // Redirect regular users to the home page
                        this.$router.push({ name: 'home-page' });
                        window.location.href = '/';
                    }

                    // Reload the entire page

                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.loginError = 'Invalid email or password';
                    } else {
                        this.loginError = 'An error occurred during login';
                    }
                });
        },
    },
};
</script>

<style>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
}

.login-box {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    width: 300px; /* Adjust the width as needed */
}

.login-form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* No need to add styles for input fields, button, and error message as Bootstrap classes take care of it. */
</style>
+
