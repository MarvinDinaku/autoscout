<template>
    <div class="container">
        <h1 class="my-4">User Management</h1>

        <!-- Add a button to open the user creation form -->
        <button class="btn btn-primary" @click="createUser">Create User</button>

        <!-- User Table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role }}</td>
                <td>
                    <button class="btn btn-primary" @click="editUser(user)">Edit</button>
                    <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            users: [],
            editingUser: null, // To store the user being edited
        };
    },
    mounted() {
        this.loadUsers();
    },
    methods: {
        loadUsers() {
            axios.get("/api/admin/users").then((response) => {
                this.users = response.data;
            });
        },
        openCreateUserForm() {
            this.showCreateUserForm = true;
        },
        createUser() {
            this.$router.push({ name: "create-user"});
        },
        cancelCreateUser() {
            this.showCreateUserForm = false;
            // Reset the form
            this.newUser = {
                name: "",
                email: "",
                password: "",
                user_type: "",
            };
        },
        editUser(user) {
            // Store the user being edited
            this.editingUser = { ...user };
            // Show the user edit form (you can create a new form for editing)
            this.showCreateUserForm = true;
        },

        updateUser() {
            // Make an API request to update the user
            axios
                .put(`/api/users/${this.editingUser.id}`, this.editingUser)
                .then(() => {
                    this.showCreateUserForm = false;
                    this.loadUsers();
                    // Reset the editingUser
                    this.editingUser = null;
                })
                .catch((error) => {
                    console.error("Error updating user: ", error);
                });
        },

        cancelEdit() {
            // Hide the user edit form
            this.showCreateUserForm = false;
            // Reset the editingUser
            this.editingUser = null;
        },

        deleteUser(userId) {
            // Make an API request to delete the user
            if (confirm("Are you sure you want to delete this user?")) {
                axios
                    .delete(`/api/admin/users/${userId}/delete`)
                    .then(() => {
                        this.loadUsers();
                    })
                    .catch((error) => {
                        console.error("Error deleting user: ", error);
                    });
            }
        },
    },
};
</script>
