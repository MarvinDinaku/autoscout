<template>
    <div class="container mt-4">
        <!-- Create Car button -->
        <router-link to="/admin/cars/create" class="btn btn-success mb-3">
            Create Car
        </router-link>

        <div class="form-group mb-3">
            <label for="search">Search:</label>
            <input type="text" id="search" class="form-control" v-model="searchQuery" @input="applySearch" />
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" id="activeCars" class="form-check-input" v-model="showActive" @change="applyFilter" />
            <label for="activeCars" class="form-check-label">Show Active Cars</label>
        </div>

        <h1 class="display-4">Car Listings</h1>
        <div v-if="loading" class="alert alert-info" role="alert">
            Loading car listings...
        </div>
        <div v-else>
            <div v-for="(car, index) in paginatedCars" :key="index" class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">{{ car.brand }}</h2>
                    <p class="card-text">Engine Size: {{ car.engine_size }}</p>
                    <p class="card-text">Price: {{ car.price }}</p>

                    <!-- Display Tags -->
                    <div v-if="car.tags && car.tags.length > 0">
                        <p>Tags: {{ car.tags.join(', ') }}</p>
                    </div>

                    <!-- Display Description -->
                    <div v-if="car.description">
                        <p>Description: {{ car.description }}</p>
                    </div>

                    <div class="btn-group" role="group" aria-label="Car Actions">
                        <button @click="editCar(car)" class="btn btn-primary">Edit</button>
                        <button @click="deleteCar(car)" class="btn btn-danger">Delete</button>
                        <button @click="toggleCarStatus(car)" class="btn btn-secondary">
                            {{ car.active ? "Disable" : "Enable" }}
                        </button>
                    </div>
                    <div v-if="car.statusMessage" class="alert alert-success mt-2" role="alert">
                        {{ car.statusMessage }}
                    </div>
                </div>
            </div>
        </div>
        <div v-if="error" class="alert alert-danger" role="alert">
            Error loading car listings: {{ error }}
        </div>
        <nav v-if="paginatedCars.length > perPage" aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <a class="page-link" @click="changePage(currentPage - 1)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item" :class="{ active: page === currentPage }" v-for="page in totalPages" :key="page">
                    <a class="page-link" @click="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <a class="page-link" @click="changePage(currentPage + 1)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            cars: [],
            loading: false,
            error: "",
            currentPage: 1,
            perPage: 9,
            searchQuery: "",
            showActive: true,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredCars.length / this.perPage) || 1;
        },
        paginatedCars() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredCars().slice(start, end);
        },
    },
    methods: {
        fetchCars() {
            this.loading = true;
            axios
                .get("/api/admin/cars")
                .then((response) => {
                    this.cars = response.data;
                    this.loading = false;
                })
                .catch(() => {
                    this.error = "An error occurred while loading car listings.";
                    this.loading = false;
                });
        },
        editCar(car) {
            // Implement edit functionality for the car
            // You can navigate to an edit page with the car's ID
            this.$router.push({ name: "edit-car", params: { id: car.id } });
        },
        deleteCar(car) {
            if (confirm("Are you sure you want to delete this car?")) {
                axios
                    .delete(`/api/admin/cars/${car.id}/delete`)
                    .then(() => {
                        // Handle success, e.g., remove the car from the list
                        this.cars = this.cars.filter((c) => c.id !== car.id);
                    })
                    .catch(() => {
                        // Handle error, e.g., show an error message
                        this.error = "Error deleting car.";
                    });
            }
        },
        toggleCarStatus(car) {
            const newStatus = !car.active; // Toggle the status
            axios
                .post(`/api/admin/cars/${car.id}/toggle`, { active: newStatus })
                .then(() => {
                    // Handle success, e.g., update the car's status
                    car.active = newStatus;
                    this.showStatusMessage(car);
                })
                .catch(() => {
                    // Handle error, e.g., show an error message
                    this.error = "Error toggling car status.";
                });
        },
        showStatusMessage(car) {
            if (car.active) {
                car.statusMessage = "Car enabled successfully.";
            } else {
                car.statusMessage = "Car disabled successfully.";
            }
            setTimeout(() => {
                car.statusMessage = null; // Clear the message after a delay
            }, 3000); // Adjust the duration as needed
        },
        changePage(page) {
            this.currentPage = page;
        },
        applySearch() {
            this.currentPage = 1; // Reset to the first page when applying a new search
        },
        applyFilter() {
            this.currentPage = 1; // Reset to the first page when applying a new filter
        },
        filteredCars() {
            const query = this.searchQuery.toLowerCase();
            return this.cars.filter(
                (car) =>
                    (car.brand.toLowerCase().includes(query) ||
                        car.model.toLowerCase().includes(query) ||
                        car.engine_size.toString().includes(query) ||
                        car.active.toString().includes(query)) &&
                    (this.showActive ? car.active : true)
            );
        },
    },
    created() {
        this.fetchCars();
    },
};
</script>

<style scoped>
/* No additional style changes are needed, as Bootstrap classes are used. */
</style>
