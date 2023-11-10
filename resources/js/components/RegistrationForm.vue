<template>
    <div class="registration-container">
        <div class="registration-box">
            <h2 class="text-center">Registration</h2>
            <form @submit.prevent="register" class="registration-form">
                <div class="mb-3">
                    <input v-model="name" type="text" class="form-control" placeholder="Name" required>
                </div>
                <div class="mb-3">
                    <input v-model="email" type="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input v-model="password" type="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <input v-model="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <div v-if="registrationError" class="alert alert-danger mt-3">{{ registrationError }}</div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            registrationError: null,
        };
    },
    methods: {
        register() {
            axios.post('/register', {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            })
                .then(response => {
                    console.log('Registration successful', response.data);
                    // Handle success, e.g., show a success message or redirect to the login page.
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        // Validation error - Display validation error messages
                        this.registrationError = 'Validation error. Please check your input.';
                        // You can access validation error messages from error.response.data.errors.
                    } else if (error.response.status === 500) {
                        // Server error - Display a generic error message
                        this.registrationError = 'An error occurred during registration.';
                    }
                });
        },
    },
};
</script>

<style>
.registration-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
}

.registration-box {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    width: 300px; /* Adjust the width as needed */
}

.registration-form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* No need to add styles for input fields, button, and error message as Bootstrap classes take care of it. */
</style>
