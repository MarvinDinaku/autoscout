<template>
    <div class="container mt-4">
        <h1 class="display-4">Car Listings</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <form @submit.prevent="searchCars" class="input-group">
                    <input
                        type="text"
                        v-model="searchQuery"
                        class="form-control"
                        placeholder="Search by name, engine size, or price"
                    />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                <router-link to="/basket" class="btn btn-primary">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="ml-2">Shopping Basket</span>
                    <span class="badge badge-light">{{ basket }}</span>
                </router-link>
            </div>
        </div>
        <div v-if="loading" class="alert alert-info" role="alert">
            Loading car listings...
        </div>
        <div v-else>
            <div v-for="(car, index) in paginatedCars" :key="index" class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">{{ car.brand }}</h2>
                    <p class="card-text">Engine Size: {{ car.engine_size }}</p>
                    <p class="card-text">Price: {{ car.price }}</p>
                    <button @click="addToBasket(car)" class="btn btn-success">Add to Basket</button>
                </div>
            </div>
        </div>
        <div v-if="error" class="alert alert-danger" role="alert">
            Error loading car listings: {{ error }}
        </div>
        <div v-if="showMessage" class="alert alert-success add-to-basket-message">
            Car added to the basket!
        </div>
        <nav v-if="totalPages > 1" aria-label="Page navigation">
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
            searchQuery: "",
            loading: false,
            error: "",
            basket: "",
            showMessage: false,
            isAuthenticated: window.isAuthenticated,
            currentPage: 1,
            perPage: 9,
        };
    },
    computed: {
        filteredCars() {
            return this.cars.filter((car) => {
                return (
                    car.brand.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    car.engine_size.toString().includes(this.searchQuery) ||
                    car.price.toString().includes(this.searchQuery)
                );
            });
        },
        totalPages() {
            return Math.ceil(this.filteredCars.length / this.perPage);
        },
        paginatedCars() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredCars.slice(start, end);
        },
    },
    methods: {
        fetchCars() {
            this.loading = true;
            axios
                .get("/homepage")
                .then((response) => {
                    this.cars = response.data;
                    this.loading = false;
                })
                .catch(() => {
                    this.error = "An error occurred while loading car listings.";
                    this.loading = false;
                });
        },
        searchCars() {
            this.currentPage = 1; // Reset to the first page when applying a new search
            this.fetchCars();
        },
        addToBasket(car) {
            axios
                .post("/cart/add/" + car.id)
                .then((response) => {
                    if (response.data) {
                        this.basket = response.data.cart;
                    }
                    this.showMessage = true;
                    setTimeout(() => {
                        this.showMessage = false;
                    }, 3000);
                })
                .catch(() => {
                    this.error = "An error occurred while adding the car to the cart.";
                });
        },
        fetchCart() {
            axios
                .get("/cart")
                .then((response) => {
                    if (response.data.cart) {
                        this.basket = response.data.cart;
                    }
                })
                .catch(() => {
                    this.error = "An error occurred while fetching the shopping cart.";
                });
        },
        changePage(page) {
            this.currentPage = page;
        },
    },
    created() {
        this.fetchCars();
        this.fetchCart();
    },
};
</script>

<style scoped>

@import 'bootstrap/dist/css/bootstrap.min.css';
/* Styling for the add-to-basket message */
.add-to-basket-message {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 10px;
    border-radius: 5px;
    animation: slide-in 0.5s ease-out;
    font-size: 16px;
}

@keyframes slide-in {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(0);
    }
}

</style>
