import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";

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

router.beforeEach((to, from, next) => {
    const auth = useAuthStore();

    if (to.meta.requiresAuth && !auth.token) {
        next({ name: "Login" });
    } else {
        next();
    }
});

export default router;
