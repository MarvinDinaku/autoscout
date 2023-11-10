<template>
    <div class="container mt-5">
        <h1 class="display-4 mb-4">Admin Panel</h1>

        <div class="row">
            <div class="col-md-6 mb-3">
                <router-link to="/admin/users" class="btn btn-primary btn-lg btn-block">User List</router-link>
            </div>
            <div class="col-md-6 mb-3">
                <router-link to="/admin/cars" class="btn btn-success btn-lg btn-block">Car List</router-link>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "AdminPanel",
};
</script>

<style scoped>
/* Add any additional styles here */
</style>
