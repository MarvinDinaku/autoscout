<template>
    <div>
        <div v-if="isAuthenticated">
            <!-- Display items associated with the user's account -->
            <div v-for="(car, index) in userBasket" :key="index" class="user-cart-item">
                <h2>{{ car.car.brand }}</h2>
                <p>Engine Size: {{ car.car.engine_size }}</p>
                <p>Price: {{ car.car.price }}</p>
                <div class="user-cart-item-actions">
                    <button @click="confirmRemove(car)" class="btn btn-danger">Remove from Basket</button>
                    <input type="number" v-model="car.quantity" @input="updateQuantity(car)" class="form-control">
                </div>
            </div>
        </div>
        <div v-else>
            <!-- Display locally stored basket items -->
            <div v-for="(car, index) in userBasket" :key="index" class="locally-stored-cart-item">
                <h2>{{ car.brand }}</h2>
                <p>Engine Size: {{ car.engine_size }}</p>
                <p>Price: {{ car.price }}</p>
                <div class="locally-stored-cart-item-actions">
                    <button @click="confirmRemove(car)" class="btn btn-danger">Remove from Basket</button>
                    <input type="number" v-model="car.quantity" @input="updateQuantity(car)" class="form-control">
                </div>
            </div>
        </div>

        <!-- Confirmation Dialog -->
        <div v-if="removeConfirmation">
            <div class="confirmation-modal">
                <p>Are you sure you want to remove car from the basket?</p>
                <button @click="removeFromUserCart(removeConfirmation)" class="btn btn-danger">Yes, Remove</button>
                <button @click="cancelRemove" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            isAuthenticated: window.isAuthenticated, // Set this based on user authentication
            userBasket: [], // Basket items associated with the user's account
            removeConfirmation: null,
        };
    },
    methods: {
        confirmRemove(car) {
            // Display the confirmation dialog
            this.removeConfirmation = car;
        },
        cancelRemove() {
            // Close the confirmation dialog
            this.removeConfirmation = null;
        },
        removeFromUserCart(car) {
            // Close the confirmation dialog
            this.removeConfirmation = null;

            axios
                .delete(`/cart/remove/${car.car_id}`)
                .then((response) => {
                    // Handle a successful removal response, e.g., update userBasket
                    if (this.isAuthenticated) {
                        const index = this.userBasket.findIndex((item) => item.id === car.id);
                        if (index !== -1) {
                            this.userBasket.splice(index, 1);
                        }
                    } else {
                        const index = Object.keys(this.userBasket).findIndex(key => this.userBasket[key].id === car.id);

                        if (index !== -1) {
                            // Convert the object to an array
                            const userBasketArray = Object.values(this.userBasket);

                            // Remove the item from the array
                            userBasketArray.splice(index, 1);

                            // Convert the array back to an object if needed
                            this.userBasket = userBasketArray.reduce((acc, item) => {
                                acc[item.car_id] = item;
                                return acc;
                            }, {});
                        }
                    }

                    // Display a success message
                    alert('Item removed successfully!');
                })
                .catch((error) => {
                    // Handle the error, e.g., show an error message
                    console.error("Error removing item from user cart: " + error);
                });
        },
        updateQuantity(car) {
            axios
                .put(`/cart/update/${car.car_id}`, { quantity: car.quantity })
                .then((response) => {
                    console.log("Updated");
                })
                .catch((error) => {
                    // Handle the error, e.g., show an error message
                    console.error("Error updating item quantity: " + error);
                });
        },
    },
    created() {
        // Fetch user-specific cart items from the server
        axios
            .get("/cart")
            .then((response) => {
                this.userBasket = response.data;
            })
            .catch((error) => {
                // Handle the error, e.g., show an error message
                console.error("Error fetching user cart items: " + error);
            });
    },
};
</script>

<style scoped>
.user-cart-item,
.locally-stored-cart-item {
    background-color: #fff;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin: 10px 0;
}

.user-cart-item h2,
.locally-stored-cart-item h2 {
    font-size: 20px;
    margin: 10px 0;
}

.user-cart-item-actions,
.locally-stored-cart-item-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-cart-item-actions button,
.locally-stored-cart-item-actions button {
    width: 48%;
}

.user-cart-item-actions input,
.locally-stored-cart-item-actions input {
    width: 48%;
}

.confirmation-modal {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
