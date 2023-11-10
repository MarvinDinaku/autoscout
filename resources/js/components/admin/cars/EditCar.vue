<template>
    <div class="container mt-5">
        <h1>Edit Car</h1>

        <form @submit.prevent="updateCar" class="mt-4">
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" id="brand" class="form-control" v-model="car.brand" />
            </div>

            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" id="model" class="form-control" v-model="car.model" />
            </div>

            <div class="form-group">
                <label for="engineSize">Engine Size:</label>
                <input type="number" id="engineSize" class="form-control" v-model="car.engine_size" step="any" min="0" />
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" class="form-control" v-model="car.price" step="any" min="0" />
            </div>

            <div class="form-group">
                <label for="registrationDate">Registration Date:</label>
                <input type="date" id="registrationDate" class="form-control" v-model="car.registration_date" />
            </div>

            <div class="form-group">
                <label for="tags">Tags (comma-separated):</label>
                <input type="text" id="tags" class="form-control" v-model="car.tags" />
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" class="form-control" v-model="car.description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Car</button>
        </form>

        <div v-if="successMessage" class="alert alert-success mt-4">
            {{ successMessage }}
        </div>

        <div v-if="error" class="alert alert-danger mt-4">
            {{ error }}
        </div>
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
                tags: "",
                description: "",
            },
            successMessage: "",
            error: "",
        };
    },
    methods: {
        updateCar() {
            axios
                .put(`/api/admin/cars/${this.$route.params.id}/update`, this.car)
                .then(() => {
                    this.successMessage = "Car updated successfully.";
                })
                .catch(() => {
                    this.error = "Error updating car.";
                });
        },
    },
    created() {
        axios
            .get(`/api/admin/cars/${this.$route.params.id}/edit/`)
            .then((response) => {
                this.car = response.data;
            })
            .catch(() => {
                this.error = "Error loading car details for editing.";
            });
    },
};
</script>

<style scoped>
/* No need for custom styles, as Bootstrap classes are used. */
</style>
