<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <router-link to="/" class="navbar-brand">Home</router-link>

        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" v-if="isLoggedIn">
                    <span class="nav-link">{{ userName }}</span>
                </li>
                <li class="nav-item" v-if="isLoggedIn">
                    <button @click="logout" class="btn btn-link nav-link">Logout</button>
                </li>
                <li class="nav-item" v-else>
                    <router-link to="/login" class="nav-link">Login</router-link>
                </li>
                <li class="nav-item" v-else>
                    <router-link to="/register" class="nav-link">Register</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            isLoggedIn: window.isAuthenticated,
            userName: "",
        };
    },
    async created() {
        await this.fetchUserData();
    },
    methods: {
        async fetchUserData() {
            try {
                // Call the Laravel API endpoint to retrieve logged user data
                const response = await axios.get("/api/user");
                // Update component data with user information
                this.isLoggedIn = true;
                this.userName = response.data.name; // Assuming the user name is in the 'name' field
            } catch (error) {
                // If an error occurs, the user is not logged in
                console.error("User not logged in:", error);
                this.isLoggedIn = false;
                this.userName = "";
            }
        },
        async logout() {
            try {
                // Call the Laravel API endpoint for logout
                await axios.post("/api/logout");

                // Reset user data
                this.isLoggedIn = false;
                this.userName = "";

                // Redirect to the home page or login page
                this.$router.push("/");
            } catch (error) {
                console.error("Error logging out:", error);
                // Handle error, show a message, etc.
            }
        },
    },
};
</script>

<style scoped>
/* Add any custom styling for the navigation menu here */
</style>
