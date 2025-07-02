import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore"; // Adjust this path if needed

const routes = [
    {
        path: "/",
        name: "Landing",
        component: () => import("@/pages/Landing.vue"),
        meta: { layout: "blank" },
    },
    {
        path: "/home",
        name: "Home",
        component: () => import("@/pages/Home.vue"),
        meta: { layout: "default", requiresAuth: true },
    },
    {
        path: "/me",
        name: "Me",
        component: () => import("@/pages/Me.vue"),
        meta: { layout: "default", requiresAuth: true },
    },
    {
        path: "/notifications",
        name: "Notifications",
        component: { template: "<div></div>" },
        meta: { layout: "default", requiresAuth: true },
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("@/pages/Login.vue"),
        meta: { layout: "blank" },
    },
    {
        path: "/signup",
        name: "SignUp",
        component: () => import("@/pages/SignUp.vue"),
        meta: { layout: "blank" },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: () => import("@/pages/NotFound.vue"),
        meta: { layout: "blank" },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard
router.beforeEach((to, from, next) => {
    // List of public pages that do not require authentication
    const publicPages = ["/", "/login", "/signup"];
    const authRequired = !publicPages.includes(to.path);
    // Pinia must have a store instance, so get it this way:
    const auth = useAuthStore();

    // If route requires auth and user is not logged in, redirect to login
    if (authRequired && !auth.token) {
        return next("/login");
    }

    // If user is logged in and tries to access login or signup, redirect to home
    if ((to.path === "/login" || to.path === "/signup") && auth.token) {
        return next("/home");
    }

    return next();
});

export default router;
