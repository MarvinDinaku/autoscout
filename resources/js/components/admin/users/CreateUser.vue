<template>
    <div>
        <h2>Create User</h2>
        <form @submit.prevent="createUser">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" class="form-control" v-model="newUser.name" required />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" v-model="newUser.email" required />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" class="form-control" v-model="newUser.password" required />
            </div>
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <select id="user_type" class="form-control" v-model="newUser.role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Create</button>
            <button class="btn btn-secondary" @click="cancelCreateUser">Cancel</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            newUser: {
                name: "",
                email: "",
                password: "",
                role: "user", // Default user type
            },
        };
    },
    methods: {
        createUser() {
            axios.post("/api/admin/users/create", this.newUser).then(() => {
                this.$emit("user-created"); // Emit an event to notify the parent component
                // Reset the form
                this.newUser = {
                    name: "",
                    email: "",
                    password: "",
                    role: "user",
                };
            });
        },
        cancelCreateUser() {
            // Reset the form
            this.newUser = {
                name: "",
                email: "",
                password: "",
                role: "user",
            };
        },
    },
};
</script>
