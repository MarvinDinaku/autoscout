<template>
    <div class="container mt-5">
        <h1 class="display-4 mb-4">Create Car</h1>

        <form @submit.prevent="createCar">
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" id="brand" class="form-control" v-model="car.brand" required />
            </div>

            <div class="form-group">
                <label for="modelType">Model Type:</label>
                <input type="text" id="modelType" class="form-control" v-model="car.model" required />
            </div>

            <div class="form-group">
                <label for="engineSize">Engine Size:</label>
                <input type="number" id="engineSize" class="form-control" v-model="car.engine_size" required />
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" class="form-control" v-model="car.price" required />
            </div>

            <div class="form-group">
                <label for="registrationDate">Registration Date:</label>
                <input type="date" id="registrationDate" class="form-control" v-model="car.registration_date" required />
            </div>

            <div class="form-group">
                <label for="tags">Tags (comma-separated):</label>
                <input type="text" id="tags" class="form-control" v-model="car.tags" />
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" class="form-control" v-model="car.description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create Car</button>

            <div v-if="successMessage" class="alert alert-success mt-3">
                {{ successMessage }}
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            car: {
                brand: "",
                model: "",
                engine_size: 0,
                price: 0,
                registration_date: "",
                tags: [],
                description: "",
            },
            tagInput: "",
            successMessage: null,
        };
    },
    methods: {
        createCar() {
            this.car.tags = this.tagInput.split(',').map(tag => tag.trim());

            axios
                .post("/api/admin/cars/create", this.car)
                .then((response) => {
                    this.successMessage = "Car created successfully!";
                    setTimeout(() => {
                        this.$router.push({ name: "admin-page" });
                    }, 2000);
                })
                .catch((error) => {
                    console.error("Error creating car:", error.response.data);
                });
        },
    },
};
</script>

<style scoped>
/* Add any additional styles here */
</style>
