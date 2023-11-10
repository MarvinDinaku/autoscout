<template>
    <div>
        <h1>Car Details</h1>
        <h2>{{ car.brand }} {{ car.model }}</h2>
        <p>Registration Date: {{ car.registrationDate }}</p>
        <p>Engine Size: {{ car.engineSize }} cc</p>
        <p>Price: ${{ car.price }}</p>

        <!-- Display Tags -->
        <div v-if="car.tags && car.tags.length > 0">
            <p>Tags: {{ car.tags.join(', ') }}</p>
        </div>

        <!-- Display Description -->
        <div v-if="car.description">
            <p>Description: {{ car.description }}</p>
        </div>

        <!-- Add more car details as needed -->
        <p v-if="error">{{ error }}</p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            car: null,
            error: null
        };
    },
    mounted() {
        const carId = this.$route.params.id;
        axios
            .get(`/api/cars/${carId}`)
            .then((response) => {
                this.car = response.data;
            })
            .catch((error) => {
                this.error = "Failed to fetch car details. Please try again later.";
            });
    }
};
</script>
