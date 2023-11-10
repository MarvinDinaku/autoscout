import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    // {
    //     path: '/',
    //     name: 'car-list',
    //     component: () => import('../components/CarList.vue')
    // },

    {
        path: '/',
        name: 'home-page',
        component: () => import('../components/Homepage.vue'),
        props: true
    },
    {
        path: '/profile',
        name: 'user-profile',
        component: () => import('../components/UserProfile.vue'),
        props: true
    },
    {
        path: '/basket',
        name: 'shopping-basket',
        component: () => import('../components/ShoppingBasket.vue'),
        props: true
    },
    {
        path: '/login',
        name: 'login-form',
        component: () => import('../components/LoginForm.vue'),
        props: true
    },
    {
        path: '/register',
        name: 'register-form',
        component: () => import('../components/RegistrationForm.vue'),
        props: true
    },
    {
        path: "/admin",

        component: () => import('../components/admin/dashboard.vue'),
        children: [
            {
                path: "", // This is the default child route
                name: "admin-page",
                component: () => import('../components/admin/cars/CarList.vue'),
            },
            {
                path: "cars",
                component: () => import('../components/admin/cars/CarList.vue'),
            },
            {
                path: '/admin/cars/edit/:id', // Define the route with a dynamic parameter for car ID
                name: 'edit-car',
                component: () => import('../components/admin/cars/EditCar.vue'),
                props: true,
            },
            {
                path: "/admin/cars/create",
                name: 'create-car',
                component: () => import('../components/admin/cars/CreateCar.vue'),
            },
            {
                path: "users",
                component: () => import('../components/admin/users/UsersList.vue'),
            },
            {
                path: "/admin/users/create",
                name: 'create-user',
                component: () => import('../components/admin/users/CreateUser.vue'),
            },
            {
                path: '/admin/users/edit/:id', // Define the route with a dynamic parameter for car ID
                name: 'edit-user',
                component: () => import('../components/admin/users/EditUser.vue'),
                props: true,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
