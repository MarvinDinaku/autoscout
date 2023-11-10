<template>
    <div>
        <h1>User Profile</h1>
        <p>Name: {{ user.name }}</p>
        <p>Email: {{ user.email }}</p>
        <!-- Add more user details as needed -->
        <p v-if="error">{{ error }}</p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            user: null,
            error: null
        };
    },
    mounted() {
        axios
            .get("/api/user/profile")
            .then((response) => {
                this.user = response.data;
            })
            .catch((error) => {
                this.error = "Failed to fetch user profile. Please try again later.";
            });
    }
};
</script>
